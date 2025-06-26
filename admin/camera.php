<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GymBoost | QR Scanner</title>
    <link rel="icon" href="../assets/img/logo/officialLogo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/admin.css" rel="stylesheet" />

    <style>
        #video {
            width: 50%;
            border-radius: 10px;
            border: 4px solid var(--primaryColor);
        }

        canvas {
            display: none;
        }

        @media (max-width: 767px) {
            #video {
                width: 100%;
                border-radius: 10px;
                border: 4px solid var(--primaryColor);
            }
        }
    </style>
</head>

<body class="bg-light">

    <?php include('../assets/shared/sidebar.php'); ?>

    <!-- Main Content -->
    <div class="main px-2 px-md-0" style="margin-left: 70px; transition: margin-left 0.25s ease-in-out;">

        <div id="dashboard" class="container-fluid py-4 px-4">
            <h2 class="heading text-center mb-3" style="color: var(--primaryColor);">SCAN A QR CODE</h2>
            <p class="text-center mb-4">Please hold your camera steady over the QR code</p>
            <div class="d-flex justify-content-center">
                <video id="video" autoplay playsinline></video>
            </div>
        </div>
    </div>

    <canvas id="canvas" hidden></canvas>

    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
    <script>
        const video = document.getElementById("video");
        const canvas = document.getElementById("canvas");
        const context = canvas.getContext("2d");

        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
            .then((stream) => {
                video.srcObject = stream;
                video.setAttribute("playsinline", true);
                requestAnimationFrame(scanQRCode);
            })
            .catch((err) => {
                console.error("Error accessing camera: ", err);
            });

        function scanQRCode() {
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, canvas.width, canvas.height);

                if (code && code.data) {
                    try {
                        const url = new URL(code.data);

                        if (url.protocol === "https:") {
                            window.location.href = url.href;
                        } else {
                            alert("Only HTTPS links are allowed.");
                        }

                    } catch (err) {
                        console.error("Invalid URL in QR code:", code.data);
                    }
                }
            }
            requestAnimationFrame(scanQRCode);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>