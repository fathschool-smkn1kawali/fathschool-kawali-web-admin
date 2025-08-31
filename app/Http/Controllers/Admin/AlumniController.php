<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use App\Models\Course;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    class AlumniController extends Controller
    {
        public function showBatchForm()
        {
            // Ambil kelas 12 dan jurusan
            $courses = Course::where('name', 'like', 'XII%')->get();
            $years = range(date('Y'), date('Y') - 10); // 10 tahun terakhir

            return inertia('Admin/Alumni/BatchPromote', [
                'courses' => $courses,
                'years' => $years,
            ]);
        }

        public function batchPromote()
        {
            // Buat atau ambil kelas Alumni
            $alumniCourse = \App\Models\Course::firstOrCreate([
                'name' => 'Alumni'
            ], [
                'description' => 'Kelas alumni untuk siswa yang sudah lulus',
            ]);

            // Ambil semua siswa kelas 12 (misal nama kelas mengandung 'XII')
            $kelas12 = \App\Models\User::where('role', 'student')
                ->whereHas('courses', function($q) {
                    $q->where('name', 'like', 'XII%');
                })->get();

            foreach ($kelas12 as $student) {
                // Hapus relasi kelas lama
                $student->courses()->detach();

                // Tambahkan ke kelas Alumni
                $student->courses()->attach($alumniCourse->id);

                // Ubah role menjadi alumni
                $student->role = 'alumni';
                $student->graduation_year = now()->year; // jika ingin set tahun kelulusan
                $student->save();
            }

            return redirect()->back()->with('success', 'Siswa kelas 12 berhasil dipindahkan ke alumni.');
        }
    }