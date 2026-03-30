# WebGameApp

VM: http://ml-lab-4d78f073-aa49-4f0e-bce2-31e5254052c7.ukwest.cloudapp.azure.com:64888/index.php

## Features

### index.php
- Displays "Welcome to Pairs" message and "Click here to play" button for registered users
- Displays "You're not using a registered session? Register now" with link for unregistered users
- Navbar conditionally shows Leaderboard or Register link based on session state
- Avatar emoji displayed in navbar from cookie

### registration.php
- Username input with server-side regex validation rejecting invalid characters
- Error message displayed inline beneath input field on invalid submission
- Medium avatar selector — choose from 7 emoji options (😀 😎 👾 🤖 🐱 🐸 🐼)
- Session variable and cookie set on successful registration (30 day expiry)
- Redirects to index.php on success

### pairs.php
- Complex implementation — 3 progressive difficulty levels
- Level 1: match pairs (2 cards, 6 total)
- Level 2: match triples (3 cards, 9 total)
- Level 3: match quadruples (4 cards, 12 total)
- Cards shuffled randomly each game using Fisher-Yates algorithm
- Board locks during match check to prevent cheating
- Attempts and timer tracked per level
- Score calculated per level: Math.floor(1000 / (attempts + timer))
- Total score accumulated across all levels
- Background turns gold (#FFD700) when personal best is beaten (localStorage)
- Submit score to leaderboard or Play Again on completion

### leaderboard.php
- Scores stored server-side in JSON file — no database required
- Sorted descending by score on every submission
- Post/Redirect/Get pattern prevents duplicate score submissions on refresh
- Supports multiple users across independent browser sessions