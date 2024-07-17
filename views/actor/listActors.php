<?php
    ob_start();
?>

<!-- Include Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />



<!-- Overlay Container -->
<div class="blur-overlay"></div>
<div class="actor-overlay" id="actorOverlay">
    <iframe id="actorDetailFrame" name="actorDetailFrame" src="" frameborder="0"></iframe>
    <img src="./public/images/close_cross.png" alt="Close" class="close" onclick="toggleActorOverlay();">
</div>

<h1 class="h1-genre">ACTEURS</h1>

    

    <!-- Swiper -->
    <div class="swiper mySwiper" style="--swiper-navigation-color: #fff;">
        <div class="swiper-wrapper">
   
            <?php
            while ($actor = $actors->fetch()) {
                ?>
                <div class="swiper-slide">
                    <figure>
                    <a href="javascript:void(0);" onclick="openActorDetail('<?=$actor['id_actor']?>')">
                        <img src="./public/images/<?=$actor['picture']?>" alt="picture of actor: <?=$actor['actor']?>">
                    </a>

                        <figcaption><a href="index.php?action=actorDetail&id=<?=$actor['id_actor']?>"><strong><?$actor['actor']?></strong></a></figcaption>
                    </figure>
            </div>
            <?php } ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
    <a href="index.php?action=addActorForm" class="addButton">Ajouter</a>

<!-- Include Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>

function openActorDetail(actorId) {
    let iframe = document.getElementById('actorDetailFrame');
    let actorOverlay = document.getElementById('actorOverlay');
    let blurOverlay = document.querySelector('.blur-overlay');

    // Set the source of the iframe to the actorDetail page with the actor ID
    iframe.src = 'index.php?action=actorDetail&id=' + actorId;

    // Show the actor overlay and the blur overlay
    actorOverlay.classList.add('active');
    blurOverlay.classList.add('active'); 
}

function toggleActorOverlay() {
    const blurOverlay = document.querySelector('.blur-overlay');
    const actorOverlay = document.getElementById('actorOverlay');
    
    // Hide both the actor overlay and the blur overlay
    blurOverlay.classList.remove('active'); 
    actorOverlay.classList.remove('active'); 
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
    $title = "Liste des acteurs";
    $content = ob_get_clean();
    require "views/template.php";
?>
