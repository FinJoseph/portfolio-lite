// Bootstrap JavaScript — configuration globale exécutée avant le montage de l'app.
//
// ⚠️ Axios a été retiré volontairement : il n'était utilisé par aucune page
// (Inertia gère toutes les requêtes HTTP), et il alourdissait le bundle initial
// de ~17 Ko gzip. Si tu as besoin d'AJAX en dehors d'Inertia, réinstalle-le ici :
//     import axios from 'axios';
//     window.axios = axios;
//     window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
