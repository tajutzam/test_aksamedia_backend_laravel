document.addEventListener('DOMContentLoaded', function() {

    const rtApiUrl = 'http://localhost:8000/api/nilaiRT';
    const stApiUrl = 'http://localhost:8000/api/nilaiST';

    function fetchData(apiUrl, name) {
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                console.log(`data for : ${name}` )
                console.log(data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    fetchData(rtApiUrl, 'RT ');
    fetchData(stApiUrl, 'ST');
});
