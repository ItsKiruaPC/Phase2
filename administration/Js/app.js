let nbClick = 0;
const test = document.getElementById("easter")

test.addEventListener('click', function()
{
    nbClick++;

    if (nbClick>6) 
    {
        window.alert("Vous avez trouvez l'easter egg");
    }
    console.log(nbClick)
})


