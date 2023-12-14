import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    async upload(event) {
        event.preventDefault();
        const form = event.target.parentNode;
        const districtId = form.getAttribute('data-id');
        const fileFormField = document.querySelector(`#file_${districtId}`);
        const filesLen = fileFormField.files.length;
        const allowedFileTypes = ['image/png', "image/jpg", "image/jpeg"];

        if (filesLen === 0) {
            alert("No file selected");
            return;
        }

        if (!allowedFileTypes.includes(fileFormField.files[0].type)) {
           alert("Invalid file type");
           return;
        }

        if (fileFormField.files[0].size > 1000000) {
            alert("Invalid file size");
            return;
        }

        const data = new FormData();

        data.append('file', fileFormField.files[0]);

        let response = await fetch(`/district/${districtId}/upload`, {
            method: 'POST',
            credentials: 'same-origin',
            body: data
        });

        if (response.status === 201) {
            const filePath = await response.text();
            const imgElement = document.getElementById(`img_${districtId}`);

            imgElement.src = filePath;
            imgElement.classList.remove('display_none');
        } else {
            alert(await response.text());
        }
    }
}