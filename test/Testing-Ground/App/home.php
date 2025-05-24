 <link rel="stylesheet" href="main-css.css" />
 <link rel="stylesheet" href="scroll.css" />

 <link rel="stylesheet" href="instruments.css" />
 <link rel="stylesheet" href="carousel.css" />
 <script src="js/lenis.js"></script>
 <script src="js/gsap.js"></script>
 <script src="js/scrollToPlugin.js"></script>
 <script src="js/scrollTrigger.js"></script>
 </div>
 <div id="body-main-cont">
     <div class="home-cont">
         <div id="home" class="home">
             <div class="cont">
                 <h1 class="fronttext">Minstrels Rhythm of Hope Inc.</h1>
             </div>

             <section id="section-1">
                 <a id="scroll-btn" href="#section-2"></a>
             </section>
         </div>
     </div>

     <div class="div-front">
         <div id="about-us" class="div-container about-us">
             <div id="about-us-horizontal">
                 <div
                     id="about-us-horizontal-inner"
                     class="about-us-horizontal-wrapper">
                     <div class="guitar">
                         <img
                             src="img/about us/guitar.png"
                             alt=""
                             fetchpriority="high" />
                     </div>
                 </div>
             </div>
             <div class="img-maincont">
                 <div class="arrow">
                     <img
                         src="https://www.freeiconspng.com/uploads/arrow-icon--myiconfinder-23.png"
                         width="350"
                         alt="Arrow icon" />
                 </div>

                 <div id="horizontalImgAboutUs" class="backImageCont">
                     <div class="about-us-text">
                         <h1 class="h1First">We are bahay musika</h1>
                         <div class="pCont">
                             <p class="pFirst">
                                 We are the poor helping the poor, youth serving youth.
                                 As volunteers, we dedicate ourselves to offering
                                 underprivileged children opportunities to develop
                                 their talents in dance, theater, singing, and visual
                                 arts, all within a supportive environment. We also
                                 provide remedial classes for those in need.
                             </p>
                             <p class="pSecond">
                                 Through these programs, we not only nurture skills in
                                 alternative education and the arts but also foster a
                                 sense of love, concern, and solidarity within our
                                 community. What began with nine young women and Mr.
                                 Alain Pronovost has grown into a mission to provide
                                 creative outlets and education for less fortunate
                                 Filipino youth. By doing so, we help them gain
                                 knowledge, express themselves artistically, and bring
                                 beauty to their surroundings.
                             </p>
                         </div>
                     </div>

                     <div class="img-sticky-container">
                         <div class="img-content">
                             <div class="img-items">
                                 <img src="img/about us/back-pictures/1.jpg" alt="" />
                             </div>
                             <div class="img-items">
                                 <img src="img/about us/back-pictures/2.jpg" alt="" />
                             </div>
                             <div class="img-items">
                                 <img src="img/about us/back-pictures/3.jpg" alt="" />
                             </div>
                             <div class="img-items">
                                 <img src="img/about us/back-pictures/4.jpg" alt="" />
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>


     </div>
     <script>
         gsap.registerPlugin(ScrollTrigger);
         ScrollTrigger.normalizeScroll(true);
         const {
             innerHeight
         } = window;
         const aboutUs = document.getElementById("about-us");
         const imgSticky = document.querySelector(
             ".img-sticky-container"
         );
         const imgItems = gsap.utils.toArray(".img-items");

         gsap
             .timeline({
                 scrollTrigger: {
                     trigger: aboutUs,
                     start: "top top",
                     pin: true,
                     scrub: 1,
                     end: "+=" + aboutUs.offsetWidth * imgItems.length,
                 },
             })
             .to(".guitar", {
                 scale: 5,
                 delay: 1,
                 ease: "linear",
                 duration: 3,
             })

             .to(
                 ".img-content", {
                     scale: 1.1,
                     ease: "ease",
                     duration: 6
                 },
                 "<"
             )

             .to(".guitar", {
                 opacity: 0,
                 delay: 1.5,
                 duration: 4
             }, "<")
             .to(".img-content", {
                 xPercent: -100 * (imgItems.length - 1),
                 ease: "sine.out",
                 snap: 1 / (imgItems.length - 1),
                 duration: 10,
             })
             .to(
                 ".about-us-text", {
                     opacity: 1,
                     ease: "linear",
                     duration: 4,
                     delay: 2
                 },

                 "<"
             )
             .to(
                 ".pCont", {
                     left: "0px",
                     ease: "ease",
                     duration: 3,
                     opacity: 1,
                     delay: 1,
                 },

                 "<"
             );
     </script>
     <div id="organization" class="div-container organization">
         <div class="title-organization">
             <h1 class="team-title">Meet our Members</h1>
         </div>
         <div class="team-cont">
             <div class="members-cont">
                 <div class="member">
                     <img
                         src="https://scontent.fmnl17-5.fna.fbcdn.net/v/t39.30808-6/441408968_10163420236257004_4684299009518192907_n.jpg?_nc_cat=110&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFBqtsEhGD7CTXFfoqQ2YiGUQI5QuOUsilRAjlC45SyKUQLpBDswtguY5sTyhapZrsprIHec0IbwzXZ3Fdz5bbj&_nc_ohc=9DwpEJ9SdtkQ7kNvgGBp7aa&_nc_zt=23&_nc_ht=scontent.fmnl17-5.fna&_nc_gid=AhLRzTDskGv_42vdVr5-Rh-&oh=00_AYA91vCLOOF1FZsl1GgUgq1Mouj89tgO1MrK5Qh6e0lpGw&oe=675D820D"
                         alt=""
                         class="member-img" />
                     <h4 class="member-name">Rosalina Tuayon</h4>
                     <h6 class="member-position">Alto 2</h6>
                     <a
                         href="https://www.facebook.com/rosalina.tuayon?mibextid=ZbWKwL">
                         <svg
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             width="32"
                             height="32">
                             <path fill="none" d="M0 0h24v24H0z"></path>
                             <path
                                 fill="white"
                                 d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"></path>
                         </svg>
                     </a>
                 </div>
                 <div class="member">
                     <img
                         src="https://scontent.fmnl17-2.fna.fbcdn.net/v/t39.30808-1/376236554_139981769182303_266034369816859575_n.jpg?stp=dst-jpg_s100x100_tt6&_nc_cat=107&ccb=1-7&_nc_sid=0ecb9b&_nc_eui2=AeHcNUtVnWT5OM5EV0T8b3l9UqvY_X8EXtJSq9j9fwRe0s5BcRj2UfanZipas6xdn8Er7AYV-0hvA2PuxbsHO9Bf&_nc_ohc=u0uasRQ-WNYQ7kNvgFvFqKY&_nc_zt=24&_nc_ht=scontent.fmnl17-2.fna&_nc_gid=AW3_WP--Z0g2mKljepfW9lv&oh=00_AYA-nCz0HWe-F-_oGjaX1rMPXeDHO92iiGbO3Y6JQrVguw&oe=675D6FA2"
                         alt=""
                         class="member-img" />
                     <h4 class="member-name">Jona Mae Tiu</h4>
                     <h6 class="member-position">Alto 2</h6>
                     <a href="https://www.facebook.com/tzunam22/?__n=K">
                         <svg
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             width="32"
                             height="32">
                             <path fill="none" d="M0 0h24v24H0z"></path>
                             <path
                                 fill="white"
                                 d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"></path>
                         </svg>
                     </a>
                 </div>
                 <div class="member">
                     <img
                         src="https://scontent.fmnl17-3.fna.fbcdn.net/v/t39.30808-6/449752233_7579849162126425_3438706241809479325_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeE8ju9BBBrGOoacD0E895ThBZD544w0_OgFkPnjjDT86A2bKQmbAiIl_srW4zt0Ixu0W4VmAIge-VVNj2jaT2dB&_nc_ohc=W27LrLAb44EQ7kNvgFbBF9z&_nc_zt=23&_nc_ht=scontent.fmnl17-3.fna&_nc_gid=A2om1-T5PbfdEFZOF40WzO-&oh=00_AYCJLGTXmUHr9s3Vj1bPEJmQlUc8nvJdQPlZ3T_60Bm0QA&oe=675D844B"
                         alt=""
                         class="member-img" />
                     <h4 class="member-name">Kaizen O. Iquiran</h4>
                     <h6 class="member-position">Alto 1</h6>
                     <a
                         href="https://www.facebook.com/kaizen.oliva.3?mibextid=ZbWKwL">
                         <svg
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             width="32"
                             height="32">
                             <path fill="none" d="M0 0h24v24H0z"></path>
                             <path
                                 fill="white"
                                 d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"></path>
                         </svg>
                     </a>
                 </div>
                 <div class="member">
                     <img
                         src="https://scontent.fmnl17-1.fna.fbcdn.net/v/t1.6435-9/143058826_3982001441833946_1175369844710506821_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeGaEHS52btZj7qL1T90DEoeNkXJtZ1Jqhc2Rcm1nUmqF0_veSkH3vddvbhKjo0GYR9opRrejkjlWgyQFf0mcJQ8&_nc_ohc=K6kz5hpVsKgQ7kNvgGFplVT&_nc_zt=23&_nc_ht=scontent.fmnl17-1.fna&_nc_gid=AQFtIm7WhSsCdyf9bCHxYvt&oh=00_AYBUF9HgOOufUB2pEPXVe9JWK6QOHMqQU52ieYN6VKWILg&oe=677E0814"
                         alt=""
                         class="member-img" />
                     <h4 class="member-name">Catherine Pama</h4>
                     <h6 class="member-position">Soprano 2</h6>
                     <a href="https://www.facebook.com/catherine.pama.1/?__n=K">
                         <svg
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             width="32"
                             height="32">
                             <path fill="none" d="M0 0h24v24H0z"></path>
                             <path
                                 fill="white"
                                 d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"></path>
                         </svg>
                     </a>
                 </div>
                 <div class="member">
                     <img
                         src="https://scontent.fmnl17-6.fna.fbcdn.net/v/t39.30808-1/469378646_8404545532988670_1010080786480385413_n.jpg?stp=cp6_dst-jpg_s100x100_tt6&_nc_cat=109&ccb=1-7&_nc_sid=0ecb9b&_nc_eui2=AeEigYhQ5TESjODLpl6HJdwj7Dlq7jx_N33sOWruPH83fdQgcF-72uY9K6nMCYvjiyxGGuU_9pTTvzX_9fEcAKvb&_nc_ohc=lZTrJ4NyXT0Q7kNvgGxIbDL&_nc_zt=24&_nc_ht=scontent.fmnl17-6.fna&_nc_gid=AGT9h0IT7gzP8GHMbvWRNeQ&oh=00_AYDgdhCYhymF80cOlqNLsHdg78EBrbqe04V4sX-4DMCLXw&oe=675D8AEC"
                         alt=""
                         class="member-img" />
                     <h4 class="member-name">Haina Jane Soleta</h4>
                     <h6 class="member-position">Soprano 2</h6>
                     <a
                         href="https://www.facebook.com/hainababes?mibextid=ZbWKwL">
                         <svg
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             width="32"
                             height="32">
                             <path fill="none" d="M0 0h24v24H0z"></path>
                             <path
                                 fill="white"
                                 d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"></path>
                         </svg>
                     </a>
                 </div>
                 <div class="member">
                     <img
                         src="https://scontent.fmnl17-4.fna.fbcdn.net/v/t1.6435-9/71332512_1409076222575873_7507133719900061696_n.jpg?_nc_cat=105&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeGzfvZenNNhLNyZyIzsbPGZD05a-tSUq6UPTlr61JSrpTync3BlFzy5iDFn4R-g4ZteptU-_IGaTqlLrXTduu83&_nc_ohc=iIY3w27HLmsQ7kNvgFWLBl3&_nc_zt=23&_nc_ht=scontent.fmnl17-4.fna&_nc_gid=AXA7rJt8TLv-LsqUMhH14jA&oh=00_AYAuY5wH2VIihd1VnI3-cwOOTR9rQToSK4drF3c2VLXDBQ&oe=677F3589"
                         alt=""
                         class="member-img" />
                     <h4 class="member-name">Anna Maria Barrameda</h4>
                     <h6 class="member-position">Soprano 2</h6>
                     <a
                         href="https://www.facebook.com/Veronicake98?mibextid=ZbWKwL">
                         <svg
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             width="32"
                             height="32">
                             <path fill="none" d="M0 0h24v24H0z"></path>
                             <path
                                 fill="white"
                                 d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"></path>
                         </svg>
                     </a>
                 </div>
                 <div class="member">
                     <img
                         src="https://scontent.fmnl17-6.fna.fbcdn.net/v/t39.30808-6/414686681_3419837758314301_4032895662928580904_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFh6KMa6fqWMoK03bedUnjh0CT313o_y2_QJPfXej_LbxWZIkbVtOrZW_uW8-wE1RGwfDJFhqZRPN-uBn_MDjVz&_nc_ohc=DDcnzCEBpwsQ7kNvgHeVtkM&_nc_zt=23&_nc_ht=scontent.fmnl17-6.fna&_nc_gid=Aj7FCklXag_SRNueWnlxNKu&oh=00_AYBTFoeSF91gbYYDE4F9LiEsFIahn96DqKVQiRNEpR4T7A&oe=675D6FFA"
                         alt=""
                         class="member-img" />
                     <h4 class="member-name">Mary Joyce Espiritu</h4>
                     <h6 class="member-position">Soprano 2</h6>
                     <a href="https://www.facebook.com/maryjoyce1995/?__n=K">
                         <svg
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             width="32"
                             height="32">
                             <path fill="none" d="M0 0h24v24H0z"></path>
                             <path
                                 fill="white"
                                 d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"></path>
                         </svg>
                     </a>
                 </div>
                 <div class="member">
                     <img
                         src="https://scontent.fmnl17-7.fna.fbcdn.net/v/t39.30808-1/456622670_3035333976609515_4255867567706286789_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=108&ccb=1-7&_nc_sid=0ecb9b&_nc_eui2=AeGq1_hgUHMJZoblw1eyvHUmSgp5P82CjbBKCnk_zYKNsPNhx9FJyBnheEN1MqetubCxkphk9y0fpiFLeIFnLv1w&_nc_ohc=6IERZafRJ7EQ7kNvgG5A5Mh&_nc_zt=24&_nc_ht=scontent.fmnl17-7.fna&_nc_gid=AQZdN3aUkihglCKJbq6xLMK&oh=00_AYAyDHyiGbzk0qjfUwZLfr2S1RS9tn6fJQAx2Ngy05FbIw&oe=675D7FBF"
                         alt=""
                         class="member-img" />
                     <h4 class="member-name">Beyonce Apan</h4>
                     <h6 class="member-position">Soprano 2</h6>
                     <a href="https://www.facebook.com/Beyonsexyy/?__n=K">
                         <svg
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             width="32"
                             height="32">
                             <path fill="none" d="M0 0h24v24H0z"></path>
                             <path
                                 fill="white"
                                 d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"></path>
                         </svg>
                     </a>
                 </div>
                 <div class="member">
                     <img
                         src="https://scontent.fmnl17-5.fna.fbcdn.net/v/t39.30808-6/441492811_10210741187881482_8235543209926105793_n.jpg?_nc_cat=110&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeHYazXD8t61KoWsOkuRhXQWEq-t_GCSGU0Sr638YJIZTWBqQCgtxroxZNJld2CSflycTdTg9X8CfmSdAuUbGhAq&_nc_ohc=ycNS-N0RT2sQ7kNvgE9FjR-&_nc_zt=23&_nc_ht=scontent.fmnl17-5.fna&_nc_gid=Aos_UHGqjeo67DA-HHe1SSz&oh=00_AYCfHsYuWw19WiY16W9roZS-e99kBU_mXYScwSdRkZQCLA&oe=675D8D93"
                         alt=""
                         class="member-img" />
                     <h4 class="member-name">Donna Sarah Malaluan</h4>
                     <h6 class="member-position">Soprano 2</h6>
                     <a href="https://www.facebook.com/donna.rabino.3/?__n=K">
                         <svg
                             xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             width="32"
                             height="32">
                             <path fill="none" d="M0 0h24v24H0z"></path>
                             <path
                                 fill="white"
                                 d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"></path>
                         </svg>
                     </a>
                 </div>
             </div>
         </div>
     </div>
     <div class="instruments"></div>
 </div>