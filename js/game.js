let boardLocked = false;
let emojis = ["😀","😎","👾","🐱","🍕","🚀"];

let cards = [];
let firstCard = null;
let secondCard = null;

let attempts = 0;
let matches = 0;

let timer = 0;
let timerInterval = null;

let score = 0;

const startBtn = document.getElementById("startBtn");
const board = document.getElementById("game-board");

const attemptsText = document.getElementById("attempts");
const timerText = document.getElementById("timer");
const scoreText = document.getElementById("score");

startBtn.addEventListener("click", startGame);

function startGame(){

    startBtn.style.display = "none";

    cards = [...emojis, ...emojis];

    shuffle(cards);

    createBoard();

    startTimer();

}

function shuffle(array){

    for(let i = array.length - 1; i > 0; i--){

        let j = Math.floor(Math.random() * (i + 1));

        let temp = array[i];
        array[i] = array[j];
        array[j] = temp;

    }

}

function createBoard(){

    board.innerHTML = "";

    cards.forEach(emoji => {

        let card = document.createElement("div");

        card.classList.add("card");

        card.dataset.emoji = emoji;

        card.innerHTML = "?";

        card.addEventListener("click", flipCard);

        board.appendChild(card);

    });

}

function flipCard(){

    if(boardLocked) return;

    if(this === firstCard) return;

    this.innerHTML = this.dataset.emoji;

    if(!firstCard){

        firstCard = this;

    }
    else{

        secondCard = this;

        attempts++;
        attemptsText.innerText = attempts;

        boardLocked = true;

        checkMatch();

    }

}

function checkMatch(){

    if(firstCard.dataset.emoji === secondCard.dataset.emoji){

        matches++;

        resetTurn();

        boardLocked = false;

        if(matches === emojis.length){
            endGame();
        }

    }
    else{

        setTimeout(() => {

            firstCard.innerHTML = "?";
            secondCard.innerHTML = "?";

            resetTurn();

            boardLocked = false;

        }, 600);

    }

}

function resetTurn(){

    firstCard = null;
    secondCard = null;

}

function startTimer(){

    timerInterval = setInterval(() => {

        timer++;

        timerText.innerText = timer;

    },1000);

}

function endGame(){

    clearInterval(timerInterval);

    score = Math.floor(1000 / (attempts + timer));

    scoreText.innerText = score;

    document.getElementById("finalScore").value = score;

    document.getElementById("game-controls").style.display = "block";

}