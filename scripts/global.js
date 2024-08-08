const user = localStorage.getItem('user');

if(!user){
    location.replace('home');
}

