let nbClick = 0;
const test = document.getElementById("easter")

test.addEventListener('click', function()
{
    nbClick++;

    if (nbClick>6) 
    {
        window.open("https://www.youtube.com/watch?v=dQw4w9WgXcQ", "_blank");
    }
    console.log(nbClick)
})


