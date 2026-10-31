<?php
require_once '../backend/config.php';

$stmt = $pdo->prepare("SELECT nom, message, date_avis FROM avis ORDER BY date_avis DESC");
$stmt->execute();
$avis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <title>Yummy -Restaurant Gastronomique</title>
    <link rel="stylesheet" href="../Style/style.css">
    <link rel="stylesheet" href="../Style/reservation.css">
    
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" >
  </head>
  <body>
    <header>
      <div id="navbar">
        <img id="logo1" src="../IMG/logoblanc-removebg-preview.png" alt="Logo Yummy" >
        <nav >
          <ul>
            <li><a href="#home">Accueil</a></li>
            <li><a href="#about">À propos</a></li>
            <li><a href="#gallery">Galerie</a></li>
            <li><a href="#menu">Menu/Carte</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </nav>
      </div>
      
      <div id="home" class="video-background">
        <video autoplay muted loop id="bg-video">
          <source src="../IMG/Yummy.mp4" type="video/mp4" >
          Votre navigateur ne supporte pas la vidéo.
        </video>
      </div>
      <div class="content">
        <button class="reserve-button">Réserver une table</button>
        <button class="reserve-button" onclick="window.location.href='../HTML/Menu.html'">passer votre commande</button>
      </div>
    </header>

    <!--Fin du header-->
    
    <!-- Modal de Réservation -->
    <input type="checkbox" id="reservation-toggle" class="reservation-toggle" >
    <div class="reservation-modal">
      <div class="reservation-content">
        <label for="reservation-toggle" class="close-button" aria-label="Fermer la fenêtre de réservation">&times;</label>
        <span class="reservation-tag">Réservation de Table</span>
        <form action="/PROJETWEB/backend/reservation.php" method="POST" class="reservation-form">
          <div class="form-group">
            <label for="reservation-name">Nom complet*</label>
            <input
              type="text" id="reservation-name" name="name"  placeholder="Entrez votre nom" required  aria-required="true"
              >
          </div>
          
          <div class="form-group">
            <label for="reservation-email">Email*</label>
            <input
              type="email"
              id="reservation-email"
              name="email"
              placeholder="E-mail"
              required
              aria-required="true"
            >
          </div>
          
          <div class="form-group">
            <label for="reservation-phone">Téléphone*</label>
            <input
              type="tel"
              id="reservation-phone"
              name="phone"
              placeholder="Ex: 06 12 34 ..."
              required
              aria-required="true"
            >
          </div>
          
          <div class="form-row">
            <div class="form-group">
              <label for="reservation-date">Date*</label>
              <input
                type="date"
                id="reservation-date"
                name="date"
                required
                aria-required="true"
              >
            </div>
            
            <div class="form-group">
              <label for="reservation-time">Heure*</label>
              <input
                type="time"
                id="reservation-time"
                name="time"
                required
                aria-required="true"
              >
            </div>
          </div>
          
          <div class="form-group">
            <label for="reservation-guests">Nombre de personnes*</label>
            <select id="reservation-guests" name="guests" required aria-required="true">
              <option value="" disabled selected>Choisissez le nombre de personnes</option>
              <option value="1">1 personne</option>
              <option value="2">2 personnes</option>
              <option value="3">3 personnes</option>
              <option value="4">4 personnes</option>
              <option value="5">5 personnes</option>
              <option value="6">6 personnes</option>
              <option value="7+">7 personnes ou plus</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="reservation-occasion">Occasion</label>
            <select id="reservation-occasion" name="occasion">
              <option value="">Sélectionnez une occasion (optionnel)</option>
              <option value="anniversaire">Anniversaire</option>
              <option value="business">Repas d'affaires</option>
              <option value="romantique">Dîner romantique</option>
              <option value="famille">Réunion de famille</option>
              <option value="autre">Autre</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="reservation-requests">Autres Détails</label>
            <textarea
              id="reservation-requests"
              name="special-requests"
              placeholder="Précisez vos demandes particulières (Allergies, etc.)"
              rows="3"
              aria-label="Demandes spéciales"
            ></textarea>
          </div>
          
          <div class="button-group">
            <button type="submit" class="submit-button">Confirmer la réservation</button>
            <button type="reset" class="reset-button">Réinitialiser</button>
          </div>
        </form>
      </div>
    </div>

     <main>
      <!-- Section À propos -->
      <section id="about" class="about-section">
        <div class="container">
          <div class="title-container">
            <h2>Notre Histoire</h2>
            <div class="title-line"></div>
          </div>

          <div class="content-grid">
            <div class="image-container">
              <div class="image-background"></div>
              <img src="../IMG/about_img.png" alt="Notre Restaurant" >
            </div>

            <div class="text-content">
              <h3>Une Tradition Culinaire Depuis 1995</h3>
              <p>
                Bienvenue chez Yummy, un restaurant où le plaisir de bien manger
                se marie avec une cuisine saine et savoureuse. Dans une ambiance
                chaleureuse et conviviale, où la diversité des saveurs se mêle au
                respect de votre bien-être. Notre restaurant vous propose des plats savoureux
                et équilibrés, notre menu varié vous invite à découvrir une
                cuisine authentique, préparée avec des ingrédients frais et de
                qualité.
              </p>

              <div class="features">
                <div class="feature">
                  <div class="feature-icon">
                    <i class="fas fa-utensils" aria-hidden="true"></i>
                  </div>
                  <div class="feature-text">
                    <h4>Cuisine Raffinée</h4>
                    <p>Des plats signatures élaborés avec passion</p>
                  </div>
                </div>

                <div class="feature">
                  <div class="feature-icon">
                    <i class="fas fa-history" aria-hidden="true"></i>
                  </div>
                  <div class="feature-text">
                    <h4>Héritage Culinaire</h4>
                    <p>Des recettes transmises de génération en génération</p>
                  </div>
                </div>

                <div class="feature">
                  <div class="feature-icon">
                    <i class="fas fa-award" aria-hidden="true"></i>
                  </div>
                  <div class="feature-text">
                    <h4>Excellence Reconnue</h4>
                    <p>Récompensé pour notre qualité exceptionnelle</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Section Galerie -->
      <section id="gallery" class="gallery">
        <h2>Notre Galerie de Plats</h2>
        <div class="title-line"></div>
        <div class="slider-container">
          <button class="slider-arrow left-arrow" aria-label="Précédent">
            &#10094;
          </button>

          <div class="gallery-container">
            <div class="gallery-item">
              <img src="../IMG/galerie/16.png" alt="Smoothie fraise" >
              <div class="overlay">
                <h3>Smoothie fraise</h3>
                <p>Un mélange velouté et gourmand de fraises.</p>
              </div>
            </div>
            <div class="gallery-item">
              <img src="../IMG/galerie/8.png" alt="Macaronis gratinés" >
              <div class="overlay">
                <h3>Macaronis gratinés</h3>
                <p>Des macaronis fondants.</p>
              </div>
            </div>
            <div class="gallery-item">
              <img src="../IMG/galerie/10.png" alt="Gratin dauphinois" >
              <div class="overlay">
                <h3>Gratin dauphinois</h3>
                <p>Pommes de terre cuites au four dans une crème.</p>
              </div>
            </div>
            <div class="gallery-item">
              <img src="../IMG/galerie/brownie.jpg" alt="Brownie" >
              <div class="overlay">
                <h3>Brownie</h3>
                <p>Délicieux brownie au chocolat.</p>
              </div>
            </div>
            <div class="gallery-item">
              <img src="../IMG/galerie/18.png" alt="Fondant au chocolat" >
              <div class="overlay">
                <h3>Fondant au chocolat</h3>
                <p>Un cœur coulant de chocolat noir intense.</p>
              </div>
            </div>
            <div class="gallery-item">
              <img src="../IMG/galerie/17.png" alt="CheeseCake" >
              <div class="overlay">
                <h3>CheeseCake</h3>
                <p>Délicieux Cheesecake aux fruits rouges.</p>
              </div>
            </div>
          </div>
          
          <div class="pagination-dots"></div>
          
          <button class="slider-arrow right-arrow" aria-label="Suivant">
            &#10095;
          </button>
        </div>
      </section>

      <!-- Section Menu -->
      <section id="menu">
        <div class="container">
          <div class="title">
            <h2>Menu</h2>
            <p>Quelques plats de notre menu.</p>
          </div>
          <div class="menu-items">
            <div class="menu-items-left">
              <div class="menu-item">
                <img src="../IMG/menu/1.png" alt="Salade César" >
                <div>
                  <h3>Salade César <span class="primary-text">| 400 DA</span></h3>
                  <p>
                    Salade croquante garnie de filets de poulet grillé, copeaux de parmesan, croûtons dorés et sauce César maison       
                  </p>
                </div>
              </div>
              <div class="menu-item">
                <img src="../IMG/menu/3.png" alt="Soupe chorba algérienne" >
                <div>
                  <h3>Soupe chorba algérienne <span class="primary-text"> | 350 DA</span></h3>
                  <p>
                    Une soupe traditionnelle parfumée aux épices, préparée avec de la viande tendre, des légumes et des pois chiches
                  </p>
                </div>
              </div>
              <div class="menu-item">
                <img src="../IMG/menu/4.png" alt="Soupe de poisson" >
                <div>
                  <h3>Soupe de poisson <span class="primary-text">| 450 DA</span></h3>
                  <p>
                    Un délicieux bouillon de la mer, avec la meilleure qualité de poisson frais
                  </p>
                </div>
              </div>
              <div class="menu-item">
                <img src="../IMG/menu/tajine.png" alt="Tajine de poulet" >
                <div>
                  <h3>Tajine de poulet <span class="primary-text">| 700 DA</span></h3>
                  <p>
                    Poulet mijoté avec légumes frais bien parfumé aux épices, cuit à feu doux 
                  </p>
                </div>
              </div>
              <div class="menu-item">
                <img src="../IMG/menu/5.png" alt="Couscous" >
                <div>
                  <h3>Couscous <span class="primary-text">| 900 DA</span></h3>
                  <p>
                    Une semoule fine et légère servie avec du poulet fondant, des légumes mijotés dans un bouillon parfumé aux épices
                  </p>
                </div>
              </div>
              <div class="menu-item">
                <img src="../IMG/menu/6.png" alt="Marmite de fruits de mer" >
                <div>
                  <h3>Marmite de fruits de mer <span class="primary-text"> | 1500 DA</span></h3>
                  <p>
                    Un assortiment raffiné de fruits de mer mijotés dans une sauce onctueuse aux saveurs marines, relevé d'ail
                  </p>
                </div>
              </div>
            </div>
            
            <div class="menu-items-right">
              <div class="menu-item">
                <img src="../IMG/menu/7.png" alt="Purée et steak" >
                <div>
                  <h3>Purée et steak <span class="primary-text">| 1000 DA</span></h3>
                  <p>
                    Un steak haché savoureux, grillé à la perfection, accompagné d'une purée de pommes de terre onctueuse
                  </p>
                </div>
              </div>
              <div class="menu-item">
                <img src="../IMG/menu/9.png" alt="Lasagnes à la bolognaise" >
                <div>
                  <h3>Lasagnes à la bolognaise <span class="primary-text">| 800 DA</span></h3>
                  <p>
                    Des pâtes fraîches superposées avec une sauce bolognaise mijotée, une béchamel onctueuse et du fromage gratiné
                  </p>
                </div>
              </div>
              <div class="menu-item">
                <img src="../IMG/menu/waffle.jpg" alt="Waffle" >
                <div>
                  <h3>Waffle <span class="primary-text">| 200 DA</span></h3>
                  <p>
                    Délicieux waffle aux fraises, sucre glace et confiture de fraises fraîches
                  </p>
                </div>
              </div>
              <div class="menu-item">
                <img src="../IMG/menu/tiramisu.jpg" alt="Tiramisu" >
                <div>
                  <h3>Tiramisu <span class="primary-text">| 200 DA</span></h3>
                  <p>
                    Un dessert italien raffiné, composé de biscuits imbibés de café, d'une crème mascarpone légère
                  </p>
                </div>
              </div>
              <div class="menu-item">
                <img src="../IMG/menu/12.png" alt="Matcha Latte" >
                <div>
                  <h3>Matcha Latte <span class="primary-text">| 400 DA</span></h3>
                  <p>
                    Un mélange onctueux de thé matcha finement moulu et de lait chaud, pour une boisson douce et énergisante
                  </p>
                </div>
              </div>
              <div class="menu-item">
                <img src="../IMG/menu/13.png" alt="Cappuccino" >
                <div>
                  <h3>Cappuccino <span class="primary-text">| 300 DA</span></h3>
                  <p>
                    Un espresso corsé surmonté d'une mousse de lait aérienne et d'une touche de cacao pour une douceur irrésistible
                  </p>
                </div>
              </div>
            </div>
          </div>
          
          <button class="btn-menu" onclick="window.location.href='../HTML/Menu.html'">
            VOIR TOUT LE MENU
          </button>
        </div>
      </section>

      <!-- Section Contact -->
      <section id="contact" class="contact-section">
        <div class="container">
          <div class="title-container">
            <span class="subtitle">CONTACTEZ-NOUS</span>
            <div class="title-line"></div>
            <p>
              <br>
              Nous sommes ravis de répondre à vos questions.<br>
              N'hésitez pas à nous contacter pour toute demande d'information.
            </p>
          </div>

          <div class="contact-wrapper">
            <div class="map-container" style="position:relative; overflow:hidden; padding-bottom:56.25%;">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3813.865336336356!2d5.032673535754879!3d36.75159615181205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x128d33663d19304d%3A0x75fa6b51b96d47b9!2zVW5pdmVyc2l0w6kgVGFyZ2Egb3V6ZW1ldXIsIELDqWphw69h!5e0!3m2!1sfr!2sdz!4v1742308271344!5m2!1sfr!2sdz"
                style="position:absolute; top:0; left:0; width:100%; height:100%; border:0;"
                allowfullscreen=""
                loading="lazy"
                title="Localisation du restaurant Yummy" 
              ></iframe>
            </div>

            <div class="contact-content">
              <div class="contact-info">
                <h3>Nos Coordonnées</h3>

                <div class="info-item">
                  <div class="info-icon">
                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                  </div>
                  <div>
                    <h4>Adresse</h4>
                    <p>À côté de l'université Targa Ouzemmour, Béjaïa</p>
                  </div>
                </div>

                <div class="info-item">
                  <div class="info-icon">
                    <i class="fas fa-phone-alt" aria-hidden="true"></i>
                  </div>
                  <div>
                    <h4>Téléphone</h4>
                    <p>+213 789 01 23 70</p>
                  </div>
                </div>

                <div class="info-item">
                  <div class="info-icon">
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                  </div>
                  <div>
                    <h4>Email</h4>
                    <p>yummy-restaurant@gmail.com</p>
                  </div>
                </div>

                <div class="info-item">
                  <div class="info-icon">
                    <i class="fas fa-clock" aria-hidden="true"></i>
                  </div>
                  <div>
                    <h4>Horaires d'ouverture</h4>
                    <p>
                      Dimanche - Jeudi: 9h à 21h <br> Vendredi - Samedi: 10h à
                      18h
                    </p>
                  </div>
                </div>
              </div>

              <div class="contact-form">
                <h3>Envoyez-nous un message</h3>
     
                <form id="contactForm" method="POST" action="/PROJETWEB/backend/contact.php">
                  <div class="form-group">
                    <label for="contact-name">Nom complet*</label>
                    <input
                      type="text"
                      id="contact-name"
                      name="name"
                      placeholder="Votre nom"
                      required
                      aria-required="true"
                    >
                  </div>

                  <div class="form-group">
                    <label for="contact-email">Email*</label>
                    <input
                      type="email"
                      id="contact-email"
                      name="email"
                      placeholder="Votre email"
                      required
                      aria-required="true"
                    >
                  </div>

                  <div class="form-group">
                    <label for="contact-message">Message*</label>
                    <textarea
                      id="contact-message"
                      name="message"
                      placeholder="Votre message"
                      required
                      aria-required="true"
                    ></textarea>
                  </div>

                  <button type="submit" class="submit-btn" aria-label="Envoyer le message">
                    <span>Envoyer le message</span>
                    <i class="fas fa-paper-plane" aria-hidden="true"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
   <!-- Avis client  -->
  
   <section class="avis-section">
  <span class="subtitle">Avis des clients</span>
  <div class="title-line"></div>
  <div class="avis-liste">
    <?php if (!empty($avis)): ?>
      <?php foreach ($avis as $a): ?>
        <div class="avis-item">
          <div class="avis-header">
            <div class="avis-nom"><i class="fas fa-user avis-icon"></i> <?= htmlspecialchars($a['nom']) ?></div>
            <div class="avis-date"><?= date('d/m/Y', strtotime($a['date_avis'])) ?></div>
          </div>
          <div class="avis-message">
            <?= nl2br(html_entity_decode($a['message'], ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Aucun avis pour le moment.</p>
    <?php endif; ?>
  </div>
</section>

    </main>
    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <!-- Élément graphique unique (cercle lumineux) -->
        <div class="light-orb"></div>

        <!-- Logo et slogan -->
        <div class="footer-branding">
          <div class="logo">
            <h2>YUMMY</h2>
            <p>Une expérience culinaire inoubliable</p>
              <button class="reserve-button" onclick="window.location.href='../HTML/login.html'"> Espace employeur </button>
            
          </div>

          <!-- Liens rapides avec effet de survol unique -->
          <div class="quick-links">
            <a href="../HTML/Menu.html" class="animated-link">Menu</a>
            <a href="#home" class="animated-link">Réservation</a>
            <a href="#contact" class="animated-link">Contact</a>
          </div>
        </div>

        <!-- Séparateur avec animation au survol -->
        <div class="animated-separator"></div>

        <!-- Bas de footer avec copyright et réseaux sociaux -->
        <div class="footer-bottom">
          <p class="copyright">
            © 2025 Yummy Restaurant. Tous droits réservés.
          </p>

          <!-- Icônes réseaux sociaux avec animation au survol -->
          <div class="social-icons">
            <a href="https://www.facebook.com/share/1BCKBZnWPp/" class="social-icon">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                viewBox="0 0 16 16"
              >
                <path
                  d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"
                />
              </svg>
            </a>
            <a href="https://www.instagram.com/yummyrestaurantt?igsh=dHNnNHptNXU1OTZ5" class="social-icon">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                viewBox="0 0 16 16"
              >
                <path
                  d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"
                />
              </svg>
            </a>
            <a href="https://x.com/yummyrestau?t=Al0t6cXq6w1pbJcsWltQyg&s=09" class="social-icon">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                viewBox="0 0 16 16"
              >
                <path
                  d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"
                />
              </svg>
            </a>
          </div>
        </div>
      </div>
    </footer>
    <script src="../Script/script.js"></script>
  </body>
</html>
