const question = document.querySelector(".question");
const gif = document.querySelector(".gif");
const yesBtn = document.querySelector(".yes-btn");
const noBtn = document.querySelector(".no-btn");

yesBtn.addEventListener("click", () => {
    question.innerHTML = "I love you to nila";
    gif.src = "https://gifdb.com/images/high/kawaii-yay-mochi-jump-4x42tyczilgub5xm.gif";
});

noBtn.addEventListener("mouseover", () => {
    const noBtnRect = noBtn.getBoundingClientRect();
    const maxX = window.innerWidth - noBtnRect.width;
    const maxY = window.innerHeight - noBtnRect.height;

    const randomX = Math.floor(Math.random() * (maxX + 1)); // Added +1 to include full width/height
    const randomY = Math.floor(Math.random() * (maxY + 1)); // Added +1 to include full width/height

    noBtn.style.position = 'absolute'; // Ensure button is positioned absolutely
    noBtn.style.left = `${randomX}px`;
    noBtn.style.top = `${randomY}px`;
});
