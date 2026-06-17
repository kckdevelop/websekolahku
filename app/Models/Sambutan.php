<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sambutan extends Model
{
    use HasFactory;

    protected $table = 'sambutans';

    protected $fillable = [
        'nama_kepala',
        'gelar_kepala',
        'foto_kepala',
        'isi_sambutan',
    ];

    /**
     * Get the principal's photo source URL.
     */
    public function getFotoSrcAttribute(): string
    {
        if ($this->foto_kepala) {
            return asset('storage/' . $this->foto_kepala);
        }
        return 'https://picsum.photos/id/1072/300/400';
    }

    /**
     * Retrieve the first Sambutan record, or create and return a default one.
     */
    public static function getSingle(): self
    {
        $defaultSpeech = "Assalamu’alaikum Warahmatullahi Wabarakatuh.\n\n"
            . "Puji syukur ke hadirat Allah SWT atas segala limpahan rahmat dan karunia-Nya, sehingga website resmi SMK Muhammadiyah 1 Bantul dapat hadir sebagai sarana informasi dan komunikasi yang transparan bagi seluruh pemangku kepentingan.\n\n"
            . "Sebagai lembaga pendidikan vokasional di bawah naungan Muhammadiyah, kami berkomitmen untuk mencetak lulusan yang tidak hanya unggul dalam kompetensi kejuruan, tetapi juga berakhlak mulia, berjiwa wirausaha, dan siap bersaing di dunia kerja maupun industri 4.0.\n\n"
            . "Melalui kolaborasi erat dengan mitra industri, kurikulum berbasis KKNI, serta pembelajaran berbasis proyek, kami memastikan setiap siswa memperoleh pengalaman belajar yang relevan dan aplikatif. Kami juga menanamkan nilai-nilai Al-Islam dan Kemuhammadiyahan sebagai fondasi karakter.\n\n"
            . "Website ini kami hadirkan sebagai wujud keterbukaan informasi—mulai dari profil sekolah, program keahlian, kegiatan, prestasi, hingga layanan digital seperti PPDB online, LMS, dan sistem PKL. Kami terbuka terhadap masukan dan kerja sama dari berbagai pihak untuk terus meningkatkan kualitas pendidikan.\n\n"
            . "Wassalamu’alaikum Warahmatullahi Wabarakatuh.";

        return self::firstOrCreate(
            ['id' => 1],
            [
                'nama_kepala' => 'Harimawan, S.Pd., M.Si.',
                'gelar_kepala' => 'Kepala Sekolah SMK Muhammadiyah 1 Bantul',
                'foto_kepala' => null,
                'isi_sambutan' => $defaultSpeech,
            ]
        );
    }
}
