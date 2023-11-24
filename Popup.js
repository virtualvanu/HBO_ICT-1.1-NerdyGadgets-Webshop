
function  main()
{
    document.addEventListener('DOMContentLoaded', function () {
        var popup = document.getElementById('popupContainer');
        var openButton = document.getElementById('openPopup');
        var closeButton = document.getElementById('closePopup');
        openButton.onclick = ShowPopup() ;

        openButton.addEventListener('click', function () {
            popup.style.display = 'block';
        });

        closeButton.addEventListener('click', function () {
            popup.style.display = 'none';
        });
    });
    }

    function ShowPopup (){
        document.getElementById("popupContainer")
        modal.style.display = "block";
    }


