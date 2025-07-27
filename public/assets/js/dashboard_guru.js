document.getElementById('absen-btn').addEventListener('click', function () {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const data = {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude
            };

           fetch('index.php?page=absen_guru', {

                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(res => {
                document.getElementById('absenStatus').innerText = res.message;
            });
        });
    } else {
        alert("Geolocation tidak didukung.");
    }
});


