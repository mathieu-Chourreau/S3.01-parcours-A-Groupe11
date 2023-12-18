#include "Recette.h"
#include "Ingredient.h"
#include <utility>
#include <map>
#include <algorithm>
#include <iostream>

class Ingredient;

Recette::Recette(){
    difficulte = 1;
}

Recette::Recette(const string& RNom){
    nom = RNom;
    difficulte = 1;
}

const string& Recette::getNom() const {
    return nom;
}

void Recette::setNom(const string& newNom) {
    nom = newNom;
}

const string& Recette::getPrix() const {
    return prix;
}

void Recette::setPrix(const string& newPrix) {
    prix = newPrix;
}

const string& Recette::getTemps() const {
    return temps;
}

void Recette::setTemps(const string& newTemps) {
    temps = newTemps;
}

int Recette::getDifficulte() const {
    return difficulte;
}

void Recette::setDifficulte(int newDifficulte) {
    difficulte = newDifficulte;
}

const string& Recette::getCategorie() const {
    return categorie;
}

void Recette::setCategorie(const string& newCategorie) {
    categorie = newCategorie;
}

Recette::ListesIngredients Recette::getMesIngredients() {
    return mesIngredients;
}