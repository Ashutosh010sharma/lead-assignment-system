<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lead;
use App\Models\LeadAssignment;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class LeadController extends Controller
{


    public function createLead(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'  => 'required|string|max:255',
        'phone' => 'required|digits:10',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }

    DB::beginTransaction();

    try {
        $lead = Lead::create([
            'name'       => $request->name,
            'phone'      => $request->phone,
            'status'     => 'open',
            'is_deleted' => 0
        ]);

        $employees = User::where('role', 'employee')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        if ($employees->isEmpty()) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'No active employees available'
            ]);
        }


        $employees = $employees->map(function ($emp) {

            // Active Leads Count
            $activeLeadCount = LeadAssignment::where('user_id', $emp->id)
                ->whereHas('lead', function ($q) {
                    $q->whereIn('status', ['open', 'in_progress'])
                      ->where('is_deleted', 0);
                })
                ->count();

            // Daily Limit Count
            $todayCount = LeadAssignment::where('user_id', $emp->id)
                ->whereDate('assigned_at', today())
                ->count();

        
            if ($todayCount >= 10) {
                $activeLeadCount = 9999;
            }


            $lastAssigned = LeadAssignment::where('user_id', $emp->id)
                ->latest('assigned_at')
                ->value('assigned_at');

            $emp->active_leads = $activeLeadCount;
            $emp->last_assigned = $lastAssigned ?? now()->subYears(10);

            return $emp;
        });

        $selectedEmployee = $employees
            ->sortBy([
                ['active_leads', 'asc'],
                ['last_assigned', 'asc']
            ])
            ->first();

        if ($selectedEmployee->active_leads == 9999) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'All employees reached daily limit'
            ]);
        }

        LeadAssignment::create([
            'lead_id'     => $lead->id,
            'user_id'     => $selectedEmployee->id,
            'assigned_at' => now(),
            'is_deleted'  => 0
        ]);

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Lead created and assigned',
            'assigned_to' => $selectedEmployee->name
        ]);

    } catch (\Exception $e) {
        DB::rollback();

        return response()->json([
            'status' => false,
            'message' => 'Something went wrong',
            'error' => $e->getMessage()
        ]);
    }
}
public function listLeads()
{
    $leads = Lead::with('assignment.user')->get();
    return view('leads-list', compact('leads'));
}

    public function create()
    {
        return view('add-user');
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'password'  => 'required|min:6',
            'role'      => 'required|in:admin,employee',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $user = User::create([
            'name'       => $request->name,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'is_active'  => 1,
            'is_deleted' => 0
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully'
        ]);
    }

    public function employeesLoad()
    {
        $employees = User::where('role', 'employee')
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get()
            ->map(function ($emp) {

                $activeLeads = LeadAssignment::where('user_id', $emp->id)
                    ->whereHas('lead', function ($q) {
                        $q->whereIn('status', ['open', 'in_progress'])
                          ->where('is_deleted', 0);
                    })
                    ->count();

                $lastAssigned = LeadAssignment::where('user_id', $emp->id)
                    ->latest('assigned_at')
                    ->value('assigned_at');

                $emp->active_leads = $activeLeads;
                $emp->last_assigned = $lastAssigned;

                return $emp;
            });
            

        return view('employees-load', compact('employees'));
    }

    public function updateStatus(Request $request)
{
    $request->validate([
        'lead_id' => 'required|exists:leads,id',
        'status'  => 'required|in:open,in_progress,closed,rejected'
    ]);

    $lead = Lead::find($request->lead_id);
    $lead->status = $request->status;
    $lead->save();

    return response()->json([
        'status' => true,
        'message' => 'Lead status updated successfully'
    ]);
}

public function reassignLeadsFromInactiveUsers($userId = null)
{
    DB::beginTransaction();

    try {
        $inactiveUsers = User::where('role', 'employee')
            ->where('is_active', 0)
            ->when($userId, function ($q) use ($userId) {
                $q->where('id', $userId);
            })
            ->get();

        foreach ($inactiveUsers as $user) {

            $assignments = LeadAssignment::where('user_id', $user->id)
                ->whereHas('lead', function ($q) {
                    $q->whereIn('status', ['open', 'in_progress'])
                      ->where('is_deleted', 0);
                })
                ->get();

            foreach ($assignments as $assignment) {

                $newEmployee = $this->getBestEmployee();

                if (!$newEmployee) {
                    continue;
                }

                if ($newEmployee->id == $user->id) {
                    continue;
                }

                $assignment->update([
                    'user_id' => $newEmployee->id,
                    'assigned_at' => now()
                ]);
            }
        }

        DB::commit();

        return "Reassignment completed";

    } catch (\Exception $e) {
        DB::rollback();
        return $e->getMessage();
    }
}
private function getBestEmployee()
{
    $employees = User::where('role', 'employee')
        ->where('is_active', 1)
        ->where('is_deleted', 0)
        ->get()
        ->filter(function ($emp) {

            $todayCount = LeadAssignment::where('user_id', $emp->id)
                ->whereDate('assigned_at', today())
                ->count();

            return $todayCount < 10; 
        })
        ->map(function ($emp) {

            $activeLeadCount = LeadAssignment::where('user_id', $emp->id)
                ->whereHas('lead', function ($q) {
                    $q->whereIn('status', ['open', 'in_progress'])
                      ->where('is_deleted', 0);
                })
                ->count();

            $lastAssigned = LeadAssignment::where('user_id', $emp->id)
                ->latest('assigned_at')
                ->value('assigned_at');

            $emp->active_leads = $activeLeadCount;
            $emp->last_assigned = $lastAssigned ?? now()->subYears(10);

            return $emp;
        });

    if ($employees->isEmpty()) {
        return null; 
    }

    return $employees->sortBy([
        ['active_leads', 'asc'],
        ['last_assigned', 'asc']
    ])->first();
}

public function userList()
{
    $users = User::where('is_deleted', 0)->where('role','employee')->get();
    return view('users-list', compact('users'));
}

public function toggleStatus(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id'
    ]);

    $user = User::find($request->user_id);

    $user->is_active = $user->is_active ? 0 : 1;
    $user->save();

    if ($user->is_active == 0) {
    $this->reassignLeadsFromInactiveUsers($user->id);
}

    return response()->json([
        'status' => true,
        'new_status' => $user->is_active
    ]);
}
}
