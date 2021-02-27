<style>

 

    @keyframes loader-animation {
        0% {
            width: 0%;
        }

        49% {
            width: 100%;
            left: 0%
        }

        50% {
            left: 100%;
            width: 0;
        }

        100% {
            left: 0%;
            width: 100%
        }
    }

    .loader {
        height: 5px;
        width: 100%;
    }

    .loader .bar {
        position: absolute;
        height: 5px;
        background-color: dodgerblue;
        animation-name: loader-animation;
        animation-duration: 3s;
        animation-iteration-count: infinite;
        animation-timing-function: ease-in-out;
    }

   
</style>
<div id="loader_container" style="display: none;">
    <div class="loader">
        <div class="bar"></div>
    </div>
</div>