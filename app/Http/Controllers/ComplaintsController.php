<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;

class ComplaintsController extends Controller
{
    // CREATE - Tambah Aduan Baru
    public function store(Request $request)
    {
        $this->validate($request, [
            'tracking_id' => 'required|unique:complaints',
            'classification' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'judul_laporan' => 'required|string',
            'deskripsi_laporan' => 'required|string',
            'date' => 'required|date',
            'instansi_tujuan' => 'required|string',
            'kategori_laporan' => 'required|string',
            'status' => 'required|string',
            'bukti' => 'nullable|string'
        ]);

        $complaint = Complaint::create($request->all());

        return response()->json($complaint, 201); // Created status
    }

    // READ - Ambil Daftar Semua Aduan
    public function index()
    {
        $complaint = Complaint::all();

        return response()->json($complaint);
    }

    // READ - Lihat Detail Aduan Berdasarkan ID
    public function show($id)
    {
        $complaint = Complaint::find($id);

        if (!$complaint) {
            return response()->json(['message' => 'Complaint not found'], 404);
        }

        return response()->json($complaint);
    }

    // UPDATE - Update Aduan Berdasarkan ID
    public function update(Request $request, $id)
    {
        $complaint = Complaint::find($id);

        if (!$complaint) {
            return response()->json(['message' => 'Complaint not found'], 404);
        }

        $complaint->update($request->all());

        return response()->json($complaint);
    }

    // DELETE - Hapus Aduan Berdasarkan ID
    public function destroy($id)
    {
        $complaint = Complaint::find($id);

        if (!$complaint) {
            return response()->json(['message' => 'Complaint not found'], 404);
        }

        $complaint->delete();

        return response()->json(['message' => 'Complaint deleted successfully']);
    }

    public function uploadEvidence(Request $request, $id)
    {
        $request->validate([
            'evidence' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:10240', // max 10MB
        ]);

        $complaint = Complaint::findOrFail($id);

        // Simpan file ke folder 'public/uploads'
        if ($request->hasFile('evidence')) {
            $file = $request->file('evidence');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/evidence', $fileName, 'public');

            // Simpan path file di database
            $complaint->bukti = '/storage/' . $filePath;
            $complaint->save();

            return response()->json([
                'success' => true,
                'message' => 'Evidence uploaded successfully',
                'file_path' => $complaint->bukti
            ]);
        }

        return response()->json(['success' => false, 'message' => 'File upload failed'], 500);
    }
}
