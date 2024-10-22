<?php include('partials-front/menu.php');  ?>
<style>
* {
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.text-center {
    text-align: center;
}

.item-slider {
    position: relative;
    width: 80%;
    height: 600px; /* Full screen height */
    max-width: 800px; /* Full width */
    margin: auto;
    overflow: hidden;
}

.slider-container {
    display: flex;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    transition: transform 0.5s ease-in-out;
}

.slide {
    width: 100%;
    height: 100%; /* Make each slide take full screen height */
    flex-shrink: 0;
    text-align: center;
    position: relative;
}

.slider-image {
    width: 100%;
    height: 100%;
    object-fit: none; /* Ensures the image covers the container without distortion */
    position: absolute;
    top: 50%;             
    left: 50%;            
    transform: translate(-50%, -50%); /* Center the image */}

button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    z-index: 1;
}

button:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

.prev {
    left: 10px;
}

.next {
    right: 10px;
}

h3 {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    font-size: 24px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    z-index: 1;
}

    </style>
</head>
<body>

    <section class="item-slider text-center">
        <div class="slider-container">

            <!-- Slide 1 -->
            <div class="slide">
                <img src="images/cake.jpeg" alt="Coffee" class="slider-image">
                <h3>Coffee</h3>
            </div>

            <!-- Slide 2 -->
            <div class="slide">
                <img src="images/icedtea.jpg" alt="Tea" class="slider-image">
                <h3>Tea</h3>
            </div>

            <!-- Slide 3 -->
            <div class="slide">
                <img src="images/ice.jpg" alt="Cake" class="slider-image">
                <h3>Cake</h3>
            </div>

            <!-- Slide 4 -->
            <div class="slide">
                <img src="images/juice.jpg" alt="Smoothie" class="slider-image">
                <h3>Smoothie</h3>
            </div>

        </div>

        <!-- Navigation Buttons -->
        <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
        <button class="next" onclick="changeSlide(1)">&#10095;</button>

    </section>

</body>
</html>

 <?php include('partials-front/footer.php'); ?>