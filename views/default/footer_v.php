    <script>
        // Crear puntos cibernéticos aleatorios
        const cyberDots = document.getElementById('cyberDots');
        for (let i = 0; i < 100; i++) {
            const dot = document.createElement('div');
            dot.classList.add('cyber-dot');
            dot.style.left = `${Math.random() * 100}%`;
            dot.style.top = `${Math.random() * 100}%`;
            dot.style.opacity = Math.random();
            dot.style.width = `${Math.random() * 3 + 1}px`;
            dot.style.height = dot.style.width;
            
            // Animación aleatoria para los puntos
            const duration = Math.random() * 20 + 10;
            dot.style.animation = `float ${duration}s infinite linear`;
            
            cyberDots.appendChild(dot);
        }
        // Añadir keyframes dinámicamente para la animación de los puntos
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes float {
                0% {
                    transform: translate(0, 0);
                    opacity: ${Math.random()};
                }
                25% {
                    transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px);
                }
                50% {
                    transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px);
                    opacity: ${Math.random()};
                }
                75% {
                    transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px);
                }
                100% {
                    transform: translate(0, 0);
                    opacity: ${Math.random()};
                }
            }
        `;
        document.head.appendChild(style);
    </script>
    <h3>C3r0<span>D4y</span></h3>    
</body>
</html>