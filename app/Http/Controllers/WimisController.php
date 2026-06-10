<?php

namespace App\Http\Controllers;

use App\Models\ProposalB1; 
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\ApprovalNotification;

class WimisController extends Controller
{
    // Halaman Form Usulan
    public function formB1() {
        return view('formulir.usulan-b1');
    }

    // Simpan Usulan
    public function storeUsulanB1(Request $request)
    {
        $validated = $request->validate([
            'judul_kegiatan'   => 'required|string',
            'project_code'     => 'required|string',
            'lokasi'           => 'required|string',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date',
            'deskripsi'        => 'nullable|string',
        ]);

        // AUTO APPROVE JIKA COORDINATOR
        $status = auth()->user()->role === 'coordinator'
            ? 'Approved'
            : 'Pending';

        // Simpan data
        $proposal = auth()->user()->proposals()->create([
            'judul_kegiatan'  => $validated['judul_kegiatan'],
            'project_code'    => $validated['project_code'],
            'lokasi'          => $validated['lokasi'],
            'tanggal_mulai'   => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'deskripsi'       => $validated['deskripsi'] ?? null,
            'status'          => $status,
        ]);

        // HANYA kirim notif kalau masih Pending
        if($status === 'Pending'){

            $coordinators = User::where(
                'role',
                'coordinator'
            )->get();

            foreach($coordinators as $coordinator){

                $coordinator->notify(
                    new ApprovalNotification(
                        'Usulan Baru',
                        auth()->user()->name . ' mengajukan Usulan B1',
                        route('approval.usulan'),
                        'info'
                    )
                );

            }
        }

        return back()->with(
            'success',
            'Usulan berhasil dikirim! Status: ' . $status
        );
    }

    public function approvalIndex()
    {
        // Cek role coordinator
        if(auth()->user()->role !== 'coordinator'){
            abort(403);
        }

        // Pending approval
        $proposals = ProposalB1::where(
            'status',
            'Pending'
        )->latest()->paginate(5, ['*'], 'pending_page');

        // Riwayat approval
        $historyProposals = ProposalB1::whereIn(
            'status',
            ['Approved', 'Rejected']
        )->latest()->paginate(5, ['*'], 'history_page');

        return view(
            'approval.kegiatan',
            compact('proposals', 'historyProposals')
        );
    }

    // Aksi Approve/Reject
    public function updateStatus(Request $request, $id)
    {

        if(auth()->user()->role !== 'coordinator'){
            abort(403);
        }

        $proposal = ProposalB1::findOrFail($id);

        // LOCK
        if($proposal->status !== 'Pending'){
            return back()->with(
                'error',
                'Usulan sudah diproses.'
            );
        }

        // VALIDASI
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
            'rejection_reason' => 'nullable|string'
        ]);

        // UPDATE
        $proposal->update([
            'status' => $request->status,
            'rejection_reason' => $request->status === 'Rejected'
                ? $request->rejection_reason
                : null
        ]);

        // NOTIFIKASI USER
        $proposal->user->notify(
            new ApprovalNotification(
                'Status Usulan B1',
                'Usulan Anda telah ' . $request->status,
                route('mydata.usulan.b1')
            )
        );

        return back()->with(
            'success',
            'Status berhasil diperbarui.'
        );
    }

    public function myTimesheet() 
    {
        $timesheets = \App\Models\TimesheetB3::where('user_id', auth()->id())->paginate(5);
        return view('mydata.timesheet', compact('timesheets'));
    }

    public function myUsulanB1()
    {
        // Mengambil data usulan milik user yang sedang login
        $usulanB1 = \App\Models\ProposalB1::where('user_id', auth()->id())->paginate(5);
        
        // Kirim data ke view
        return view('mydata.usulan-b1', compact('usulanB1'));
    }

    public function storeTimesheet(Request $request) {
        // Validasi input harus SAMA dengan name di blade
        $validated = $request->validate([
            'tanggal'    => 'required|date',
            'project'    => 'required|string',
            'lokasi'     => 'required|string',
            'total_jam'  => 'required|integer',
            'claim_type' => 'required|string',
            'aktivitas'  => 'required|string',
        ]);

        // dd(auth()->user()->role);
        $status = (auth()->user()->role === 'coordinator') ? 'Approved' : 'Pending';

        // Mapping agar sesuai dengan kolom database
        $data =[
            'user_id'          => auth()->id(),
            'tanggal_kegiatan' => $validated['tanggal'], // Mapping 'tanggal' ke 'tanggal_kegiatan'
            'project'          => $validated['project'],
            'lokasi'           => $validated['lokasi'],
            'total_jam'        => $validated['total_jam'],
            'claim_type'       => $validated['claim_type'],
            'aktivitas'        => $validated['aktivitas'],
            'status_approval'  => $status
        ];

        \App\Models\TimesheetB3::create($data);

        $coordinators = User::where('role', 'coordinator')->get();

        foreach($coordinators as $coordinator){
            $coordinator->notify(
                new ApprovalNotification(
                    'Timesheet Baru',
                    auth()->user()->name . ' mengirim Timesheet B3',
                    route('approval.timesheet'),
                    'info'
                )
            );
        }
        
        return back()->with('success', 'Data tersimpan! Status: ' . $status);
    }

    public function myTimesheetB3() {
        // Menggunakan tanggal_kegiatan sesuai migrasi
        $months = \App\Models\TimesheetB3::selectRaw('DATE_FORMAT(tanggal_kegiatan, "%Y-%m") as month')
                    ->distinct()->get();
        return view('mydata.timesheet-b3', compact('months'));
    }

    public function detailTimesheet($month) {
        // Menggunakan tanggal_kegiatan
        $details = \App\Models\TimesheetB3::whereRaw("DATE_FORMAT(tanggal_kegiatan, '%Y-%m') = ?", [$month])->get();
        return view('mydata.timesheet-detail', compact('details', 'month'));
    }

    public function approvalTimesheetIndex()
    {

        if(auth()->user()->role !== 'coordinator'){
            abort(403);
        }

        // Pending
        $timesheets = \App\Models\TimesheetB3::where(
            'status_approval',
            'Pending'
        )->latest()->paginate(5);

        // Riwayat
        $historyTimesheets = \App\Models\TimesheetB3::whereIn(
            'status_approval',
            ['Approved', 'Rejected']
        )->latest()->paginate(5);

        return view(
            'approval.timesheet',
            compact('timesheets', 'historyTimesheets')
        );
    }

    public function updateTimesheetStatus(Request $request, $id)
    {

        if(auth()->user()->role !== 'coordinator'){
            abort(403);
        }

        $ts = \App\Models\TimesheetB3::findOrFail($id);

        if($ts->status_approval !== 'Pending'){
            return back()->with(
                'error',
                'Timesheet sudah diproses.'
            );
        }

        $ts->update([
            'status_approval' => $request->status,
            'rejection_reason' => $request->rejection_reason
        ]);

        if($request->status === 'Approved'){

            $ts->user->notify(
                new ApprovalNotification(
                    'Timesheet Disetujui',
                    'Timesheet Anda telah disetujui coordinator.',
                    route('mydata.timesheet'),
                    'success'
                )
            );

        } else {

            $ts->user->notify(
                new ApprovalNotification(
                    'Timesheet Ditolak',
                    'Timesheet ditolak. Alasan: ' . $request->rejection_reason,
                    route('mydata.timesheet'),
                    'danger'
                )
            );

        }

        return back()->with(
            'success',
            'Timesheet berhasil di-' . $request->status
        );
    }

    public function editUsulan($id)
    {
        $proposal = ProposalB1::where(
            'user_id',
            auth()->id()
        )->findOrFail($id);

        return view(
            'mydata.edit-usulan',
            compact('proposal')
        );
    }

    public function updateUsulan(Request $request, $id)
    {
        $proposal = ProposalB1::where(
            'user_id',
            auth()->id()
        )->findOrFail($id);

        // LOCK
        if($proposal->status !== 'Pending'){
            return back()->with(
                'error',
                'Usulan sudah diproses dan terkunci.'
            );
        }

        $request->validate([
            'judul_kegiatan' => 'required',
            'project_code' => 'required',
            'lokasi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        $proposal->update([
            'judul_kegiatan' => $request->judul_kegiatan,
            'project_code' => $request->project_code,
            'lokasi' => $request->lokasi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('mydata.usulan.b1')
            ->with(
                'success',
                'Usulan berhasil diperbarui.'
            );
    }

    public function deleteUsulan($id)
    {
        $proposal = ProposalB1::where(
            'user_id',
            auth()->id()
        )->findOrFail($id);

        // LOCK
        if($proposal->status !== 'Pending'){
            return back()->with(
                'error',
                'Usulan tidak bisa dihapus.'
            );
        }

        $proposal->delete();

        return back()->with(
            'success',
            'Usulan berhasil dihapus.'
        );
    }

    public function editTimesheet($id)
    {
        $timesheet = \App\Models\TimesheetB3::where(
            'user_id',
            auth()->id()
        )->findOrFail($id);

        return view(
            'mydata.edit-timesheet',
            compact('timesheet')
        );
    }

    public function updateTimesheet(Request $request, $id)
    {
        $timesheet = \App\Models\TimesheetB3::where(
            'user_id',
            auth()->id()
        )->findOrFail($id);

        // LOCK
        if($timesheet->status_approval !== 'Pending'){
            return back()->with(
                'error',
                'Timesheet sudah diproses dan terkunci.'
            );
        }

        $request->validate([
            'tanggal' => 'required|date',
            'project' => 'required',
            'lokasi' => 'required',
            'total_jam' => 'required|integer',
            'claim_type' => 'required',
            'aktivitas' => 'required',
        ]);

        $timesheet->update([
            'tanggal_kegiatan' => $request->tanggal,
            'project' => $request->project,
            'lokasi' => $request->lokasi,
            'total_jam' => $request->total_jam,
            'claim_type' => $request->claim_type,
            'aktivitas' => $request->aktivitas,
        ]);

        return redirect()
            ->route('mydata.timesheet')
            ->with(
                'success',
                'Timesheet berhasil diperbarui.'
            );
    }

    public function deleteTimesheet($id)
    {
        $timesheet = \App\Models\TimesheetB3::where(
            'user_id',
            auth()->id()
        )->findOrFail($id);

        // LOCK
        if($timesheet->status_approval !== 'Pending'){
            return back()->with(
                'error',
                'Timesheet tidak bisa dihapus.'
            );
        }

        $timesheet->delete();

        return back()->with(
            'success',
            'Timesheet berhasil dihapus.'
        );
    }
}