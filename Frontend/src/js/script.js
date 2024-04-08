document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault(); 

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    
    fetch('backend.php', {
        method: 'POST',
        body: JSON.stringify({ username: username, password: password }),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(function(response) {
        return response.json();
    }).then(function(data) {
        console.log(data);
        
    }).catch(function(error) {
        console.error('Error:', error);
    });
});
