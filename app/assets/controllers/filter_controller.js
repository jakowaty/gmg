import {Controller} from '@hotwired/stimulus';
import Bootbox from "bootbox";

export default class extends Controller {
    filter(event) {
        event.preventDefault();

        const dialog = Bootbox.confirm({
            title: "Filtrowanie",
            message: `
            <form class="filter_modal">
                
                <div class="filter_row">
                    <span class="field_label">Nazwa</span>
                    <div class="form-check form-check-inline">                     
                        <input type="text" placeholder="nazwa..."  name="filters[name]" class="form-control" autocomplete="off">
                    </div>
                </div>
              
                <div class="filter_row">
                    <span class="field_label">Powierzchnia</span>
                    <div class="form-check form-check-inline">                     
                        <input type="number" step="0.01" placeholder="powierzchnia od..."  name="filters[areaFrom]" class="mr-2 form-control" autocomplete="off">
                        <input type="number" step="0.01" placeholder="powierzchnia do..."  name="filters[areaTo]" class="form-control" autocomplete="off">
                    </div>
                </div>
                
                <div class="filter_row">
                    <span class="field_label">Ludność</span>
                    <div class="form-check form-check-inline">                     
                        <input type="number" placeholder="liczba ludności od..."  name="filters[citizensFrom]" class="mr-2 form-control" autocomplete="off">
                        <input type="number" placeholder="liczba ludności do..."  name="filters[citizensTo]" class="form-control" autocomplete="off">
                    </div>
                </div>
            </form>
            `,
            buttons: {
                confirm: {
                    label: 'Zastosuj',
                    className: 'btn-primary'
                },
                cancel: {
                    label: 'Anuluj',
                    className: 'btn-outline-primary'
                }
            },
            callback: function (result) {
                if (result) {
                    const formElement = document.querySelector('.bootbox-body form');
                    const formParams = new URLSearchParams(new FormData(formElement))

                    window.location.search = formParams.toString();
                    return false;
                }
                return true;
            }
        });
    }
}