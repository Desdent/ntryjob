<?php $this->layout('layout', ['title' => 'Inicio']) ?>

<!-- HERO -->
<section class="hero">
    <div class="container" id="contenedorSitio">
        <h1>Encuentra tu sitio</h1>
        <p>Buscar empleo no tiene por qué ser complicado</p>
        
        <div class="search-box">
            <input type="text" placeholder="Buscar...">
            <select name="queBuscar" id="quebuscar">
                <option value="ofertas" selected>En ofertas</option>
                <option value="empresas">En empresas</option>
                <option value="ciclos">En ciclos</option>
                <option value="ciudad">En ciudades</option>
                <option value="ofertas">En provincias</option>
                
            </select>

            <button class="btn-search">Buscar</button>
        </div>
    </div>
</section>

<!-- OFERTAS DESTACADAS -->
<section class="ofertas-destacadas container-azul">
    <div class="container">
        <h2>Ofertas destacadas</h2>
        
        <div class="ofertas-container">
            <!-- Card 1 -->
            <div class="grupo-tarjetas">
                <div class="oferta-card">
                    <div class="oferta-logo">
                        <img src="/assets/imagenes/placeholder_logo_ofertas.png" alt="Logo">
                    </div>
                    <h3>Desarrollador Front-End Junior</h3>
                    <span class="oferta-badge">OFERTA POPULAR</span>
                    <p>Únete a nuestro equipo para gestionar campañas de PPC y SEO a nivel internacional</p>
                    <a href="#" class="btn-ver-oferta">Ver Oferta</a>
                </div>

                <!-- Card 2 -->
                <div class="oferta-card">
                    <div class="oferta-logo">
                        <img src="/assets/imagenes/placeholder_logo_ofertas.png" alt="Logo">
                    </div>
                    <h3>Especialista en Marketing Digital</h3>
                    <span class="oferta-badge">OFERTA CARA</span>
                    <p>Únete a nuestro equipo para gestionar campañas de PPC y SEO a nivel internacional</p>
                    <a href="#" class="btn-ver-oferta">Ver Oferta</a>
                </div>

                <!-- Card 3 -->
                <div class="oferta-card">
                    <div class="oferta-logo">
                        <img src="/assets/imagenes/placeholder_logo_ofertas.png" alt="Logo">
                    </div>
                    <h3>Diseñador UX/UI Senior</h3>
                    <span class="oferta-badge">OFERTA POPULAR</span>
                    <p>Únete a nuestro equipo para gestionar campañas de PPC y SEO a nivel internacional</p>
                    <a href="#" class="btn-ver-oferta">Ver Oferta</a>
                </div>
            </div>



            <div class="grupo-tarjetas">
                <div class="oferta-card">
                    <div class="oferta-logo">
                        <img src="/assets/imagenes/placeholder_logo_ofertas.png" alt="Logo">
                    </div>
                    <h3>Desarrollador Front-End Junior</h3>
                    <span class="oferta-badge">OFERTA POPULAR</span>
                    <p>Únete a nuestro equipo para gestionar campañas de PPC y SEO a nivel internacional</p>
                    <a href="#" class="btn-ver-oferta">Ver Oferta</a>
                </div>

                <!-- Card 2 -->
                <div class="oferta-card">
                    <div class="oferta-logo">
                        <img src="/assets/imagenes/placeholder_logo_ofertas.png" alt="Logo">
                    </div>
                    <h3>Especialista en Marketing Digital</h3>
                    <span class="oferta-badge">OFERTA CARA</span>
                    <p>Únete a nuestro equipo para gestionar campañas de PPC y SEO a nivel internacional</p>
                    <a href="#" class="btn-ver-oferta">Ver Oferta</a>
                </div>

                <!-- Card 3 -->
                <div class="oferta-card">
                    <div class="oferta-logo">
                        <img src="/assets/imagenes/placeholder_logo_ofertas.png" alt="Logo">
                    </div>
                    <h3>Diseñador UX/UI Senior</h3>
                    <span class="oferta-badge">OFERTA POPULAR</span>
                    <p>Únete a nuestro equipo para gestionar campañas de PPC y SEO a nivel internacional</p>
                    <a href="#" class="btn-ver-oferta">Ver Oferta</a>
                </div>
            </div>
        </div>

        <div class="ofertas-footer">
            <a href="#" class="btn-ver-todos">Ver todos los ofertas</a>
        </div>
    </div>
</section>

<!-- NUESTROS COLABORADORES -->
<section class="colaboradores">
    <div class="container">
        <h2>Nuestros Colaboradores</h2>
        
        <div class="colaboradores-container">
            <div class="colaborador-card">
                <img src="/assets/imagenes/placeholder_logo_ofertas.png" alt="Nter">
            </div>
            <div class="colaborador-card">
                <img src="/assets/imagenes/placeholder_logo_ofertas.png" alt="NTT Data">
            </div>
            <div class="colaborador-card">
                <img src="/assets/imagenes/placeholder_logo_ofertas.png" alt="Colaborador 3">
            </div>
        </div>
    </div>
</section>

<!-- FOOTER CTA -->
<section class="footer-cta container-azul">
    <div class="container">
        <div class="footer-cta-container">
            <div class="footer-cta-card">
                <h3>Nunca terminamos de aprender</h3>
                <p>¿Tienes alguna sugerencia que crees que podría mejorar nuestro portal? ¡Cuéntanosla!</p>
                <a href="#" class="btn-footer">Preguntas Frecuentes</a>
            </div>
            <div class="footer-cta-card">
                <h3>Contacto</h3>
                <p>¿Dudas? ¿Problemas? Estaremos aquí para ayudarte. Accede a nuestra sección de Preguntas Frecuentes o plantéanos una pregunta en nuestro formulario Contacto con un simple clic directamente.</p>
                <a href="#" class="btn-footer">Contactar Soporte</a>
            </div>
        </div>
    </div>
</section>
