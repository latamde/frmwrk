document.addEventListener("DOMContentLoaded", function() {
    const API_URL = "https://gist.githubusercontent.com/juanbrujo/0fd2f4d126b3ce5a95a7dd1f28b3d8dd/raw/b8575eb82dce974fd2647f46819a7568278396bd/comunas-regiones.json";
    const regionSelect = document.getElementById("region");
    const comunaSelect = document.getElementById("comuna");
    
    fetch(API_URL)
        .then(response => response.json())
        .then(data => {
            data.regiones.forEach(region => {
                const option = document.createElement("option");
                option.text = region.region;
                regionSelect.add(option);
            });
        });

    // actualiza comunas al cambiar la región
    regionSelect.addEventListener("change", function() {
        const selectedRegion = regionSelect.value;
        comunaSelect.innerHTML = ""; // limpia select de comunas

        fetch(API_URL)
            .then(response => response.json())
            .then(data => {
                const region = data.regiones.find(r => r.region === selectedRegion);
                if (region) {
                    comunaSelect.removeAttribute("disabled");
                    region.comunas.forEach(comuna => {
                        const option = document.createElement("option");
                        option.text = comuna;
                        comunaSelect.add(option);
                    });
                }
            });
    });
});

function descargarCSV() {
    fetch('/descargarCSV', {
        method: 'POST'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al descargar el archivo CSV');
        }
        return response.blob();
    })
    .then(blob => {
        const url = window.URL.createObjectURL(new Blob([blob]));
        const a = document.createElement('a');
        a.href = url;
        a.download = 'datos.csv';
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        a.remove();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

document.getElementById('descargaCSV').addEventListener('click', descargarCSV);