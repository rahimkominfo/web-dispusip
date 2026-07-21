<?php

namespace App\Controllers;

class Ppid extends BaseController
{
    public function berkala()
    {
        $data = [
            'title'    => 'Informasi Berkala',
            'embedUrl' => 'https://ppidkab.sinjaikab.go.id/v2/widgets/embed?type=latest&display=card&mode=static&columns=4&autoplay=0&limit=5&unit_id=730730&category=Informasi%20Berkala&t=1784606318550&origin='
        ];

        return view('ppid/berkala', $data);
    }

    public function setiap_saat()
    {
        $data = [
            'title'    => 'Informasi Setiap Saat',
            'embedUrl' => 'https://ppidkab.sinjaikab.go.id/v2/widgets/embed?type=latest&display=card&mode=static&columns=4&autoplay=0&limit=5&unit_id=730730&category=Informasi%20Setiap%20Saat&t=1784606413506&origin='
        ];

        return view('ppid/setiap_saat', $data);
    }

    public function serta_merta()
    {
        $data = [
            'title'    => 'Informasi Serta Merta',
            'embedUrl' => 'https://ppidkab.sinjaikab.go.id/v2/widgets/embed?type=latest&display=card&mode=static&columns=4&autoplay=0&limit=5&unit_id=730730&category=Informasi%20Serta%20Merta&t=1784606462712&origin='
        ];

        return view('ppid/serta_merta', $data);
    }

    public function dikecualikan()
    {
        $data = [
            'title'    => 'Informasi Dikecualikan',
            'embedUrl' => 'https://ppidkab.sinjaikab.go.id/v2/widgets/embed?type=latest&display=card&mode=static&columns=4&autoplay=0&limit=5&unit_id=730730&category=Informasi%20Dikecualikan&t=1784606523252&origin='
        ];

        return view('ppid/dikecualikan', $data);
    }
}
