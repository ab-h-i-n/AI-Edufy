
        const ctx = document.getElementById('progress-chart')?.getContext('2d');

        // Pass PHP variables to JavaScript
        const easySolved = Number(document.getElementById('easy-solved').innerText);
        const mediumSolved = Number(document.getElementById('medium-solved').innerText);
        const hardSolved = Number(document.getElementById('hard-solved').innerText);

        const easyTotal = Number(document.getElementById('easy-total').innerText);
        const mediumTotal = Number(document.getElementById('medium-total').innerText);
        const hardTotal = Number(document.getElementById('hard-total').innerText);

        const totalQuestions = easyTotal + mediumTotal + hardTotal;
        const totalSolved = easySolved + mediumSolved + hardSolved;

        const progressChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        easySolved, 
                        mediumSolved, 
                        hardSolved,
                        totalQuestions - totalSolved  
                    ],
                    backgroundColor: ['#008000', '#ff4500', '#ff0000', '#2d2d2d'], 
                    borderWidth: 0,
                    cutout: '70%',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });


// edit

const editProfileBtn = document.querySelector('.edit-profile-btn');
editProfileBtn.addEventListener("click" , ()=>{
    window.lo
})