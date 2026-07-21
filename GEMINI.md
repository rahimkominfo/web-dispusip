Buatkan 4 halaman berikut:
/ppid/berkala
/ppid/setiap_saat
/ppid/serta_merta
/ppid/dikecualikan

Buat controller:
app/Controllers/Ppid.php

yang memiliki method:
berkala()
setiap_saat()
serta_merta()
dikecualikan()

Masing-masing method mengirimkan data:
title
embedUrl
ke view.
Routing

Tambahkan route berikut:
$routes->get('ppid/berkala', 'Ppid::berkala');
$routes->get('ppid/setiap_saat', 'Ppid::setiap_saat');
$routes->get('ppid/serta_merta', 'Ppid::serta_merta');
$routes->get('ppid/dikecualikan', 'Ppid::dikecualikan');
View


Data Embed
1. Berkala
Base URL:
https://ppidkab.sinjaikab.go.id/v2/widgets/embed?type=latest&display=card&mode=static&columns=4&autoplay=0&limit=5&unit_id=730730&category=Informasi%20Berkala&t=1784606318550&origin=

2. Setiap Saat
https://ppidkab.sinjaikab.go.id/v2/widgets/embed?type=latest&display=card&mode=static&columns=4&autoplay=0&limit=5&unit_id=730730&category=Informasi%20Setiap%20Saat&t=1784606413506&origin=

3. Serta Merta
https://ppidkab.sinjaikab.go.id/v2/widgets/embed?type=latest&display=card&mode=static&columns=4&autoplay=0&limit=5&unit_id=730730&category=Informasi%20Serta%20Merta&t=1784606462712&origin=

4. Dikecualikan
https://ppidkab.sinjaikab.go.id/v2/widgets/embed?type=latest&display=card&mode=static&columns=4&autoplay=0&limit=5&unit_id=730730&category=Informasi%20Dikecualikan&t=1784606523252&origin=
