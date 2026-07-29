import axios from "axios";
  // ↑ Axios : librairie HTTP, utilisée ici pour toute requête AJAX custom que tu ferais en dehors d'Inertia

window.axios = axios;
  // ↑ rend axios accessible globalement (window.axios) dans toute l'app JS, pas seulement dans ce fichier

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
  // ↑ ajoute un header sur CHAQUE requête axios pour que Laravel sache que c'est une requête AJAX
// (utile pour que Laravel renvoie du JSON au lieu d'une redirection HTML en cas d'erreur, par exemple)
