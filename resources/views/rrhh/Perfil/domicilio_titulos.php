<h6 class="">Domicilio 

    <?php if(isset($get_id_d['0']['lat']) && isset($get_id_d['0']['lng'])){?>
        <a style="display: -webkit-inline-box;" href="https://www.google.com/maps/search/?api=1&query=<?php if(isset($get_id_d['0']['lat'])) {echo $get_id_d['0']['lat'];}?>,<?php if(isset($get_id_d['0']['lng'])) {echo $get_id_d['0']['lng'];}?>&zoom=20" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 100 100" width="40px" height="40px" style="margin-bottom: 6px;" >
                <path fill="#60be92" d="M81,76.667V23.333C81,20.388,78.612,18,75.667,18H22.333C19.388,18,17,20.388,17,23.333v53.333	C17,79.612,19.388,82,22.333,82h53.333C78.612,82,81,79.612,81,76.667z"/>
                <path fill="#78a2d2" d="M22.769,81.999l52.461,0L48.999,55.768L22.769,81.999z"/>
                <path fill="#ceccbe" d="M80.999,76.23l0-52.461L54.768,49.999L80.999,76.23z"/>
                <path fill="#f9e65c" d="M75.666,17.5h-0.643L16.5,76.023v0.643c0,3.217,2.617,5.833,5.833,5.833h0.643l58.523-58.523v-0.643	C81.499,20.116,78.882,17.5,75.666,17.5z"/>
                <path fill="#1f212b" d="M22.976,82.499h-0.643c-3.216,0-5.833-2.616-5.833-5.833v-0.643L75.023,17.5h0.643	c3.217,0,5.833,2.616,5.833,5.833v0.643L22.976,82.499z M17.5,76.438v0.229c0,2.665,2.168,4.833,4.833,4.833h0.229l57.938-57.938	v-0.229c0-2.665-2.168-4.833-4.833-4.833h-0.229L17.5,76.438z"/>
                <path fill="#fff" d="M55.426,49.949l-6.476,6.477l26.073,26.073h0.643c3.217,0,5.833-2.616,5.833-5.833v-0.643	L55.426,49.949z"/>
                <path fill="#1f212b" d="M75.667,83H22.333C18.841,83,16,80.159,16,76.667V23.333C16,19.841,18.841,17,22.333,17h53.333	C79.159,17,82,19.841,82,23.333v53.334C82,80.159,79.159,83,75.667,83z M22.333,19C19.944,19,18,20.943,18,23.333v53.334	C18,79.057,19.944,81,22.333,81h53.333C78.056,81,80,79.057,80,76.667V23.333C80,20.943,78.056,19,75.667,19H22.333z"/>
                <path fill="#f15b6c" d="M70.5,67.5c0.552,0,1-0.448,1-1c0-2.5,1.5-9,5.875-16C81.09,44.556,88.5,38,88.5,29.5	c0-9.941-8.059-18-18-18s-18,8.059-18,18c0,8.5,7.41,15.056,11.125,21C68,57.5,69.5,64,69.5,66.5C69.5,67.052,69.948,67.5,70.5,67.5	z"/>
                <circle cx="70.5" cy="29.5" r="7" fill="#b07454"/>
                <path fill="#1f212b" d="M70.5,68c-0.827,0-1.5-0.673-1.5-1.5c0-2.496-1.574-8.976-5.799-15.735	c-0.975-1.56-2.206-3.16-3.51-4.854C56.086,41.223,52,35.911,52,29.5C52,19.299,60.299,11,70.5,11S89,19.299,89,29.5	c0,6.411-4.086,11.723-7.691,16.41c-1.304,1.694-2.535,3.295-3.51,4.854C73.574,57.524,72,64.004,72,66.5	C72,67.327,71.327,68,70.5,68z M70.5,12C60.851,12,53,19.851,53,29.5c0,6.07,3.976,11.239,7.484,15.801	c1.319,1.714,2.564,3.334,3.565,4.935C68.415,57.221,70,63.789,70,66.5c0,0.275,0.224,0.5,0.5,0.5s0.5-0.225,0.5-0.5	c0-2.711,1.585-9.279,5.951-16.265c1-1.601,2.246-3.221,3.565-4.935C84.024,40.739,88,35.57,88,29.5C88,19.851,80.149,12,70.5,12z"/>
                <path fill="#1f212b" d="M70.5,37c-4.136,0-7.5-3.364-7.5-7.5s3.364-7.5,7.5-7.5s7.5,3.364,7.5,7.5S74.636,37,70.5,37z M70.5,23c-3.584,0-6.5,2.916-6.5,6.5s2.916,6.5,6.5,6.5s6.5-2.916,6.5-6.5S74.084,23,70.5,23z"/>
                <path fill="#1f212b" d="M73.5,49.688c-0.087,0-0.176-0.022-0.256-0.071c-0.237-0.142-0.314-0.448-0.173-0.686l0.157-0.266	c0.108-0.184,0.216-0.367,0.331-0.551c1.102-1.762,2.402-3.453,3.779-5.244C80.617,38.608,84,34.211,84,29.5	c0-3.163-1.13-6.244-3.184-8.678c-0.178-0.211-0.151-0.526,0.06-0.704c0.211-0.179,0.526-0.151,0.705,0.06	C83.786,22.791,85,26.102,85,29.5c0,5.051-3.488,9.586-6.862,13.971c-1.369,1.78-2.655,3.452-3.731,5.174	c-0.11,0.176-0.213,0.353-0.317,0.528l-0.161,0.271C73.835,49.601,73.669,49.688,73.5,49.688z"/>
                <path fill="#1f212b" d="M72.5,16.16c-0.024,0-0.048-0.002-0.072-0.005C71.697,16.049,71.084,16,70.5,16	c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5c0.633,0,1.292,0.053,2.072,0.165c0.273,0.04,0.462,0.293,0.423,0.566	C72.959,15.98,72.745,16.16,72.5,16.16z"/>
                <path fill="#1f212b" d="M78.5,18.523c-0.099,0-0.199-0.029-0.286-0.09c-1.183-0.826-2.48-1.453-3.857-1.864	c-0.265-0.079-0.415-0.358-0.336-0.623s0.356-0.412,0.622-0.336c1.479,0.442,2.873,1.116,4.143,2.003	c0.227,0.158,0.282,0.47,0.124,0.696C78.813,18.449,78.657,18.523,78.5,18.523z"/>
                <path fill="#1f212b" d="M75.666,82.499h-0.643l-26.73-26.73l6.476-6.477l12.085,12.086c0.195,0.195,0.195,0.512,0,0.707	s-0.512,0.195-0.707,0L54.768,50.706l-5.062,5.063l25.73,25.73h0.229c2.665,0,4.833-2.168,4.833-4.833v-0.229l-7.353-7.353	c-0.195-0.195-0.195-0.512,0-0.707s0.512-0.195,0.707,0l7.646,7.646v0.643C81.499,79.883,78.882,82.499,75.666,82.499z"/>
                <path fill="#fff" d="M41.368,31.5h-1.113H32.5v4h4.395c-0.911,1.78-2.758,3-4.895,3c-3.038,0-5.5-2.462-5.5-5.5	c0-3.038,2.462-5.5,5.5-5.5c1.413,0,2.698,0.538,3.672,1.413l2.828-2.828l0,0C36.8,24.486,34.518,23.5,32,23.5	c-5.247,0-9.5,4.253-9.5,9.5s4.253,9.5,9.5,9.5c4.38,0,8.058-2.968,9.156-7c0.217-0.798,0.344-1.633,0.344-2.5	C41.5,32.488,41.447,31.99,41.368,31.5z"/><path fill="#1f212b" d="M32,43c-5.514,0-10-4.486-10-10s4.486-10,10-10c2.547,0,4.977,0.966,6.843,2.721	c0.099,0.093,0.156,0.222,0.158,0.356c0.002,0.136-0.051,0.266-0.146,0.361l-2.829,2.828c-0.188,0.188-0.491,0.194-0.688,0.019	C34.416,28.456,33.231,28,32,28c-2.757,0-5,2.243-5,5s2.243,5,5,5c1.595,0,3.061-0.749,3.996-2H32.5c-0.276,0-0.5-0.224-0.5-0.5v-4	c0-0.276,0.224-0.5,0.5-0.5h8.868c0.245,0,0.455,0.178,0.494,0.42C41.955,31.995,42,32.513,42,33c0,0.867-0.122,1.753-0.361,2.632	C40.456,39.97,36.493,43,32,43z M32,24c-4.962,0-9,4.037-9,9s4.038,9,9,9c4.043,0,7.61-2.727,8.674-6.632	C40.89,34.575,41,33.778,41,33c0-0.313-0.021-0.644-0.065-1H33v3h3.895c0.174,0,0.336,0.091,0.427,0.239s0.098,0.334,0.019,0.488	C36.307,37.746,34.261,39,32,39c-3.309,0-6-2.691-6-6s2.691-6,6-6c1.32,0,2.596,0.437,3.641,1.237l2.131-2.131	C36.15,24.744,34.12,24,32,24z"/>
            </svg>
        </a>
    <?php }else{?>


    <?php }?>

</h6>