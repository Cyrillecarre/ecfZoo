
    document.addEventListener('DOMContentLoaded', function () {
        const backButton = document.getElementById('backButton');
        
        if (backButton) {
            backButton.addEventListener('click', function (event) {
                // Prévenir le comportement par défaut
                event.preventDefault();
    
                // Recharger la page
                window.location.href = backButton.href;
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        var swiper = new Swiper('.swiper-container', {
            loop: true,
            centeredSlides: true,
            slidesPerView: 2,
            spaceBetween: 20,

            coverflowEffect: {
                rotate: 20,
                stretch: 0,
                depth: 500,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'coverflow',
        });
    });

    function showAnimalDetails(animalId) {
        fetch(`/area/animal-details/${animalId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const animalDetailsDiv = document.getElementById('animalDetails'); 
                
                animalDetailsDiv.innerHTML = `
                <div class="animalDetails hidden">
                    <h2>${data.name}</h2>
                    <p class="pictureDe">
                        ${data.picture ? `<img src="${data.picture}" alt="${data.name}">` : '<p>Aucune image disponible</p>'}
                    </p>
                    <p><strong>État de santé :</strong> ${data.state}</p>
                    <p><strong>Nourriture :</strong></p>
                    ${data.foods.map((food, index) => `<p style="animation-delay: ${1.2 + (index * 0.2)}s">${food.name} - Quantité : ${food.quantity} grammes</p>`).join('')}
                </div>
                `;
                
                animalDetailsDiv.classList.remove('hidden');
                animalDetailsDiv.classList.add('show');
                animalDetailsDiv.scrollIntoView({ behavior: 'smooth' });

                setTimeout(() => {
                    const detailsContent = animalDetailsDiv.querySelector('.animalDetails');
                    detailsContent.classList.remove('hidden');
                    detailsContent.classList.add('show');
                }, 500);
            })
            .catch(error => console.error('Error fetching animal details:', error));
    }
    
    
    
    
    

    