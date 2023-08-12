#!/bin/bash

animate() {
  local emojis=("🍞" "🍅" "🧀" "🍕" "🔥" "🍕" "🍳" "🍕" "🍽️")
  local delay=0.3

  for emoji in "${emojis[@]}"; do
    printf "\r%s" "$emoji"
    sleep "$delay"
  done
}

echo "Collecting ingredients..."
animate

./vendor/bin/sail up -d;

sleep 2

echo "Pouring cheese..."
animate

./vendor/bin/sail artisan test;

sleep 2

echo "Adding toppings..."
animate

./vendor/bin/sail artisan migrate:fresh;

sleep 2

echo "Cooking in the oven..."
animate

./vendor/bin/sail artisan migrate;

# add seeder "sail artisan seed"

echo "Serving in a moment..."
animate

# Simulating the pizza cooking process...
sleep 2

printf "\rPizza is ready! Bon appetit 🍕🎉\n"
