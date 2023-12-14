# gmg

Napisz aplikację, która na żądanie pobierze informacje o dzielnicach z Krakowa i Gdańska na podstawie danych opublikowanych na stronach:
https://www.bip.krakow.pl/?bip_id=1&mmi=453
·        https://www.gdansk.pl/dzielnice
https://www.gdansk.pl/subpages/dzielnice/html/4-dzielnice_mapa_alert.php?id=34

Dane do uzyskania to:
·        nazwa,
·        powierzchnia,
·        liczba ludności.

Zaprezentuj je na stronie tak aby można było po nich:
·        filtrować:
o   nazwa,
o   powierzchnia (filtr od - do),
o   liczba ludności (filtr od - do),
·        sortować.

Sortowanie i filtrowanie powinno się odbyć po stronie backendu. Dodatkowo zaimplementuj CRUD na tych danych i ich pobieranie/aktualizację na życzenie (nie powinny się duplikować). Pobranie może być w formie www, albo akcji w konsoli.

Przy każdej dzielnicy znajdować się powinno również pole umożliwiające wstawienie zdjęcia dzielnicy. Po wybraniu pliku, powinna się wyświetlić jego miniaturka.
Formularz z polem powinien być obsłużony przez Vanilla JS lub framework Vue. Upload pliku musi odbywać się asynchronicznie, bez przeładowania strony.

Część backendową zadania należy wykonać w frameworku Symfony.

Dodatkowym atutem będzie wystawienie tego na Dockerze.

Gotowe zadanie należy umieścić na gitlab.com lub github.com i przesłać do nas adres do projektu.

