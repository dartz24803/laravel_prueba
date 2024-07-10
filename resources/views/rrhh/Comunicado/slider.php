<?php  $sesion =  $_SESSION['usuario'][0];?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider</title>
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>template/assets/img/favicon.png" sizes="16x16">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/especiales/sliders/sliderstyle.css">
    <script src="<?php echo base_url(); ?>template/assets/js/libs/jquery-3.1.1.min.js"></script>
</head>
<body>

<?php foreach($slider as $list) {  ?>
    <?php if($list['tipo_slide'] == 1){  ?>
           <?php echo "<div class='slide' data-timing={$list['duracion']} data-fadein={$list['entrada_slide']} data-fadeout={$list['salida_slide']}>"; ?>
           <?php echo '<img loading="lazy" src="'.$list['archivoslide'].'">'; ?>
           <?php echo "<section class='text'>
                    <h1></h1>
                    <p></p>
                </section>
                </div>";?>

      <?php  }elseif ($list['tipo_slide'] == 2){ ?>           
      <?php echo "<div class='slide' data-timing={$list['duracion']} data-fadein={$list['entrada_slide']} data-fadeout={$list['salida_slide']}>"; ?>
      <?php echo '<video loading="lazy" autoplay muted >
                    <source src="'.$list['archivoslide'].'" type="video/mp4">
                   </video>'; 
      ?>
      <?php echo "<section class='text'>
                    <h1></h1>
                    <p></p>
                </section>
                </div>";
      ?>
    <?php  }else{ ?>
        <?php echo ""; ?>
        <?php  } ?>
<?php } ?>

    <script>
            var slides = $(".slide");
            var lastSlideIndex = slides.length-1;
            var currentSlideIndex = 0;
            var defaultTiming = 1000;
            var defaultFadeInTime = 1000;
            var defaultFadeOutTime = 1000;
            // Show slide function
            function showSlide() {
                
                var thisSlide = slides.eq(currentSlideIndex);
                
                // Delays
                var timing = parseFloat(thisSlide.attr("data-timing")) * 1000;	// Transform seconds in milliseconds
                if(isNaN(timing)){timing=defaultTiming; console.log("NOTICE: ----------- data-timing is missing, using default.");}
                var fadeInTime = parseFloat(thisSlide.attr("data-fadein")) * 1000;
                if(isNaN(fadeInTime)){fadeInTime=defaultFadeInTime; console.log("NOTICE: ----------- data-fadein is missing, using default.");}
                var fadeOutTime = parseFloat(thisSlide.attr("data-fadeout")) * 1000;
                if(isNaN(fadeOutTime)){fadeOutTime=defaultFadeOutTime; console.log("NOTICE: ----------- data-fadeout is missing, using default.");}
                
                console.log("Slide: "+currentSlideIndex+":\n Display time: "+timing+" millisec.\n Fadein: "+fadeInTime+" millisec.\n Fadeout: "+fadeOutTime+" millisec.");
                thisSlide.animate({"opacity":1},fadeInTime);
                
                // If this slide contains a video
                if(slides.eq(currentSlideIndex).find("video").length > 0){
                    
                    // Prevents more than 1 video to play at the same time
                    $("video").each(function(){
                        console.log("All video paused.")
                        $(this)[0].pause();
                    });
                    
                    // Play this video from the start
                    var thisVideo = slides.eq(currentSlideIndex).find("video")[0];
                    thisVideo.currentTime = 0;
                    console.log("Video playing.");
                    thisVideo.play()
                }
                
                // Prepare for next slide
                currentSlideIndex++;
                
                // Reset to slide 0 if last was reached
                if(currentSlideIndex>lastSlideIndex){
                    currentSlideIndex=0;
                }
                
                setTimeout(function(){
                    // Fade out previous slide
                    var previousSlideIndex = currentSlideIndex-1;
                    
                    
                    // If previous was last slide
                    if(previousSlideIndex == -1){
                        previousSlideIndex = lastSlideIndex;
                    }
                    
                    // If previous slide was set to pause
                    if(slides.eq(previousSlideIndex).attr("data-videopause")=="true"){
                        console.log("Video has been paused.");
                        slides.eq(previousSlideIndex).find("video")[0].pause();
                    }
                    
                    slides.eq(previousSlideIndex).animate({"opacity":0},fadeOutTime);
                    showSlide();
                }, timing);
            }
            // Init
            showSlide();
    </script>

</body>
</html>