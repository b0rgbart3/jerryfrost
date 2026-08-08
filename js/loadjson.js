function loadJsonFile(filePath, callback) {
    fetch(filePath)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            // Handle the JSON data, you can pass it to a callback function
            if (typeof callback === 'function') {
                callback(data);
            }
        })
        .catch(error => {
            console.error('Error loading JSON file:', error);
        });
}

// Example usage:
// const jsonFilePath = '../uploads/paintings.json';

// loadJsonFile(jsonFilePath, (jsonData) => {
//     // Use the jsonData object here
//     console.log('FRESH JSON:');
//     console.log(jsonData);
// });