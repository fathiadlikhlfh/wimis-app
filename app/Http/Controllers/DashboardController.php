<?php

namespace App\Http\Controllers;

use App\Models\ProposalB1;
use App\Models\TimesheetB3;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $unreadCount = $user->unreadNotifications()->count();

        // Staff
        $timesheetToday = TimesheetB3::where(
            'user_id',
            $user->id
        )->whereDate(
            'tanggal_kegiatan',
            today()
        )->exists();

        $pendingProposal =
            ProposalB1::where(
                'user_id',
                $user->id
            )->where(
                'status',
                'Pending'
            )->count()

            +

            TimesheetB3::where(
                'user_id',
                $user->id
            )->where(
                'status_approval',
                'Pending'
            )->count();


        $rejectedProposal =
            ProposalB1::where(
                'user_id',
                $user->id
            )->where(
                'status',
                'Rejected'
            )->count()

            +

            TimesheetB3::where(
                'user_id',
                $user->id
            )->where(
                'status_approval',
                'Rejected'
            )->count();

        // Coordinator
        $approvalPending =
            ProposalB1::where('status', 'Pending')->count()
            +
            TimesheetB3::where(
                'status_approval',
                'Pending'
            )->count();

        $staffCount = User::where(
            'role',
            'staff'
        )->count();

        $filledToday = TimesheetB3::whereDate(
            'tanggal_kegiatan',
            today()
        )->distinct('user_id')
         ->count('user_id');

        $staffNotFilled = max(
            0,
            $staffCount - $filledToday
        );

        $submissionToday =
            ProposalB1::whereDate(
                'created_at',
                today()
            )->count()
            +
            TimesheetB3::whereDate(
                'created_at',
                today()
            )->count();

        return view(
            'dashboard',
            compact(
                'timesheetToday',
                'pendingProposal',
                'rejectedProposal',
                'approvalPending',
                'staffNotFilled',
                'submissionToday',
                'unreadCount'
            )
        );
    }
}