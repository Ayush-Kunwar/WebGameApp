let boardLocked = false;

let level = 1;
let totalScore = 0;
let levelScores = {};
const levelText = document.getElementById("levelDisplay");
let firstSelections = [];
let cards = [];

let attempts = 0;
let timer = 0;
let timerInterval = null;

let matchSize = 2;
let cardGroups = 3;

const startBtn = document.getElementById("startBtn");
const board = document.getElementById("game-board");

const attemptsText = document.getElementById("attempts");
const timerText = document.getElementById("timer");
const scoreText = document.getElementById("score");

startBtn.addEventListener("click", startGame);

function startGame() {
    startBtn.style.display = "none";
    startLevel();
}

function startLevel() {
    resetStats();
    levelText.innerText = level;
    if (level === 1) {
        matchSize = 2;
        cardGroups = 3;
    } else if (level === 2) {
        matchSize = 3;
        cardGroups = 3;
    } else {
        matchSize = 4;
        cardGroups = 3;
    }

    generateCards();
    createBoard();
    startTimer();
}

function generateCards() {
    cards = [];

    for (let i = 0; i < cardGroups; i++) {
        let emoji = generateRandomEmoji();
        for (let j = 0; j < matchSize; j++) {
            cards.push(emoji);
        }
    }

    shuffle(cards);
}

function generateRandomEmoji() {
    const faces = ["😀", "😎", "🤖", "👾", "🐱", "🐸", "🐼", "👻"];
    return faces[Math.floor(Math.random() * faces.length)];
}

function shuffle(array) {
    for (let i = array.length - 1; i > 0; i--) {
        let j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

function createBoard() {
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

function flipCard() {
    if (boardLocked) return;
    if (firstSelections.includes(this)) return;

    this.innerHTML = this.dataset.emoji;
    firstSelections.push(this);

    if (firstSelections.length === matchSize) {
        attempts++;
        attemptsText.innerText = attempts;
        boardLocked = true;
        checkMatch();
    }
}

function checkMatch() {
    let allMatch = firstSelections.every(
        card => card.dataset.emoji === firstSelections[0].dataset.emoji
    );

    if (allMatch) {
        firstSelections = [];
        boardLocked = false;

        let matchedCards = document.querySelectorAll(
            `.card:not([data-matched="true"])`
        );

        let unmatched = [...matchedCards].filter(
            card => card.innerHTML === "?"
        );

        if (unmatched.length === 0) {
            completeLevel();
        }
    } else {
        setTimeout(() => {
            firstSelections.forEach(card => {
                card.innerHTML = "?";
            });

            firstSelections = [];
            boardLocked = false;
        }, 700);
    }
}

function completeLevel() {
    clearInterval(timerInterval);

    let levelScore = Math.floor(1000 / (attempts + timer));
    levelScores["Level " + level] = levelScore;
    totalScore += levelScore;

    scoreText.innerText = totalScore;

    let best = localStorage.getItem("bestLevel" + level);

    if (!best || levelScore > best) {
        localStorage.setItem("bestLevel" + level, levelScore);
        document.getElementById("game-container").style.background = "#FFD700";
    }

    if (level < 3) {
        level++;
        setTimeout(startLevel, 1500);
    } else {
        endGame();
    }
}

function startTimer() {
    timerInterval = setInterval(() => {
        timer++;
        timerText.innerText = timer;
    }, 1000);
}

function resetStats() {
    attempts = 0;
    timer = 0;
    firstSelections = [];
    attemptsText.innerText = "0";
    timerText.innerText = "0";
    clearInterval(timerInterval);
}

function endGame() {
    document.getElementById("finalScore").value = totalScore;
    document.getElementById("game-controls").style.display = "block";
}

function restartGame() {
    location.reload();
}