<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404</title>
    <style>
        @import url("https://fonts.googleapis.com/css?family=Barlow+Condensed:300,400,500,600,700,800,900|Barlow:300,400,500,600,700,800,900&display=swap");

        .about .social.linkedin .icon {
            background-image: url(https://rafaelavlucas.github.io/assets/codepen/linkedin.svg);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        ul,
        li,
        button,
        a,
        i,
        input,
        body {
            margin: 0;
            padding: 0;
            list-style: none;
            border: 0;
            -webkit-tap-highlight-color: transparent;
            text-decoration: none;
            color: inherit;
        }



        body {
            margin: 0;
            padding: 0;
            height: auto;
            font-family: "Barlow", sans-serif;
            background: #ffffff;
        }

        .wrapper {
            display: grid;
            grid-template-columns: 1fr;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow-x: hidden;
        }

        .wrapper .container {
            margin: 0 auto;
            transition: all 0.4s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .wrapper .container .scene {
            position: absolute;
            width: 100vw;
            height: 100vh;
            vertical-align: middle;
        }


        .wrapper .container .p404 {
            width: 60%;
            height: 60%;
            top: 20% !important;
            left: 20% !important;
            min-width: 400px;
            min-height: 400px;
        }



        @keyframes content {
            0% {
                width: 0;
            }
        }



        @keyframes pieceLeft {
            0% {
            }

            50% {
                left: 80%;
                width: 10%;
            }

            100% {
            }
        }

        @keyframes pieceRight {
            0% {
            }

            50% {
                right: 80%;
                width: 10%;
            }

            100% {
            }
        }

        @media screen and (max-width: 799px) {
            .wrapper .container .p404 {
                width: 90%;
                height: 90%;
                top: 5% !important;
                left: 5% !important;
                min-width: 280px;
                min-height: 280px;
            }
        }

        @media screen and (max-height: 660px) {
            .wrapper .container .one,
            .wrapper .container .two,
            .wrapper .container .three,
            .wrapper .container .circle,
            .wrapper .container .p404 {
                min-width: 280px;
                min-height: 280px;
                width: 60%;
                height: 60%;
                top: 20% !important;
                left: 20% !important;
            }
        }

        .wrapper .container .text {
            width: 60%;
            height: 40%;
            min-width: 400px;
            min-height: 500px;
            position: absolute;
            margin: 40px 0;
            animation: text 0.6s 1.8s ease backwards;
        }

        @keyframes text {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }
        }

        @media screen and (max-width: 799px) {
            .wrapper .container .text {
                min-height: 400px;
                height: 80%;
            }
        }

        .wrapper .container .text article {
            width: 400px;
            position: absolute;
            bottom: 0;
            z-index: 4;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        @media screen and (max-width: 799px) {
            .wrapper .container .text article {
                width: 100%;
            }
        }

        .wrapper .container .text article p {
            color: white;
            font-size: 18px;
            letter-spacing: 0.6px;
            margin-bottom: 40px;
            text-shadow: 6px 6px 10px #32243E;
        }

        .wrapper .container .text article button {
            height: 40px;
            padding: 0 30px;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0px 15px 20px rgba(54, 24, 79, 0.5);
            z-index: 3;
            color: #695681;
            background-color: white;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .wrapper .container .text article button:hover {
            box-shadow: 0px 10px 10px -10px rgba(54, 24, 79, 0.5);
            transform: translateY(5px);
            background: #FB8A8A;
            color: white;
        }

        .wrapper .container .p404 {
            font-size: 200px;
            font-weight: 700;
            letter-spacing: 4px;
            color: white;
            display: flex !important;
            justify-content: center;
            align-items: center;
            position: absolute;
            z-index: 2;
        }

        @media screen and (max-width: 799px) {
            .wrapper .container .p404 {
                font-size: 100px;
            }
        }

        @keyframes anime404 {
            0% {
                opacity: 0;
                transform: scale(10) skew(20deg, 20deg);
            }
        }

        .wrapper .container .p404:nth-of-type(2) {
            color: #36184F;
            z-index: 1;
            filter: blur(10px);
            opacity: 0.8;
        }




        @keyframes circle {
            0% {
                width: 0;
                height: 0;
            }
        }

        @media screen and (max-width: 799px) {
            .wrapper .container .circle:before {
                width: 400px;
                height: 400px;
            }
        }

        @media screen and (max-width: 799px) {
            .wrapper .container .one .content:before {
                width: 300px;
                height: 300px;
            }
        }


    </style>
</head>
<body>
<section class="wrapper">
    <div class="container">

        <div id="scene" class="scene" data-hover-only="false">
            <p class="p404" data-depth="0.50">404</p>
            <p class="p404" data-depth="0.10">404</p>
        </div>
    </div>
</section>
</body>
</html>