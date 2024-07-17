<?php
ob_start();
?>

<!-- Include Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


<!-- Overlay Container -->
<div class="blur-overlay"></div>
<div class="director-overlay" id="directorOverlay">
    <iframe id="directorDetailFrame" name="directorDetailFrame" src="" frameborder="0"></iframe>
    <img src="./public/images/close_cross.png" alt="Close" class="close" onclick="toggleDirectorOverlay();">
</div>


    <h1 class="h1-genre">RÉALISATEURS</h1>
    <a href="index.php?action=addDirectorForm" style="visibility: hidden;">Ajouter un Réalisateur</a>

    <!-- Swiper -->
    <div class="swiper mySwiper" style="--swiper-navigation-color: #fff;">
        <div class="swiper-wrapper">
   
            <?php
            while ($director = $directors->fetch()) {
                ?>
                <div class="swiper-slide">
                    <figure>
                    <a href="javascript:void(0);" onclick="openDirectorDetail('<?=$director['id_director']?>')">
                        <img src="./public/images/<?=$director['picture']?>" alt="picture of director: <?=$director['director']?>">
                    </a>

                        <figcaption><a href="index.php?action=directorDetail&id=<?=$director['id_director']?>"><strong><?$director['director']?></strong></a></figcaption>
                    </figure>
            </div>
            <?php } ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
    <a href="index.php?action=addDirectorForm" class="addButton">Ajouter</a>

<!-- Include Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
 
function openDirectorDetail(directorId) {
    let iframe = document.getElementById('directorDetailFrame');
    let directorOverlay = document.getElementById('directorOverlay');
    let blurOverlay = document.querySelector('.blur-overlay');

    // Set the source of the iframe to the directorDetail page with the director ID
    iframe.src = 'index.php?action=directorDetail&id=' + directorId;

    // Show the director overlay and the blur overlay
    directorOverlay.classList.add('active');
    blurOverlay.classList.add('active'); 
}

function toggleDirectorOverlay() {
    const blurOverlay = document.querySelector('.blur-overlay');
    const directorOverlay = document.getElementById('directorOverlay');
    
    // Hide both the director overlay and the blur overlay
    blurOverlay.classList.remove('active'); // Change toggle to remove
    directorOverlay.classList.remove('active'); // Change toggle to remove
}


    let swiper = new Swiper(".mySwiper", {
        slidesPerView: 6,
        spaceBetween: 5,
        freeMode: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
        },
    });
</script>

<?php
$title = "Liste des réalisateurs";
$content = ob_get_clean();
require "views/template.php";
?>
