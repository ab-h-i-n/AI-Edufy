const ctx = document.getElementById('progress-chart').getContext('2d');
    

    const easySolved = 100;
    const mediumSolved = 500;
    const hardSolved = 2000;

    const easyTotal = 826;
    const mediumTotal = 1723;
    const hardTotal = 745;

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
                backgroundColor: ['#1da1f2', '#ffc107', '#dc3545', '#2d2d2d'], 
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

    // Update solved count in text
    document.getElementById('solved-count').innerText = totalSolved;
    document.getElementById('easy-count').innerText = `${easySolved}/${easyTotal}`;
    document.getElementById('medium-count').innerText = `${mediumSolved}/${mediumTotal}`;
    document.getElementById('hard-count').innerText = `${hardSolved}/${hardTotal}`;