#include "Recette.h"
#include "Ingredient.h"
#include <utility>
#include <algorithm>
#include <map>
#include <iostream>
using namespace std;

class Ingredient;

Recette::Recette(){
    difficulte = 1;
}

Recette::Recette(const string& RNom){
    nom = RNom;
    difficulte = 1;
}

const int& Recette::getId() const {
    return id;
}

void Recette::setId(const int& nvId) {
    id = nvId;
}

const string& Recette::getNom() const {
    return nom;
}

void Recette::setNom(const string& nvNom) {
    nom = nvNom;
}

const float& Recette::getPrix() const {
    return prix;
}

void Recette::setPrix(const float& nvPrix) {
    prix = nvPrix;
}

const float& Recette::getTemps() const {
    return temps;
}

void Recette::setTemps(const float& nvTemps) {
    temps = nvTemps;
}

const string& Recette::getDifficulte() const {
    return difficulte;
}

void Recette::setDifficulte(const string& nvDifficulte) {
    difficulte = nvDifficulte;
}

const string& Recette::getCategorie() const {
    return categorie;
}

void Recette::setCategorie(const string& nvCategorie) {
    categorie = nvCategorie;
}

Recette::ListesIngredients Recette::getMesIngredients() {
    return mesIngredients;
}


bool compareIngredient(const auto &pair, const string &nomIngredient){
    return (pair.first.getNom() == nomIngredient);
}

bool Recette::existeIngredient(string& nomIngredient) const {
    auto existe = find_if(mesIngredients.begin(), mesIngredients.end(), compareIngredient(this, nomIngredient));
}

void Recette::ajouterIngredient(const Ingredient& ingredient, const string& poids) {
    bool ingredientExiste = existeIngredient(ingredient.getNom());

    if (ingredientExiste) {
        mesIngredients.push_back(make_pair(ingredient, poids));
    }

}

void retirerIngredient(string &nomIngredient){
    if (existeIngredient(nomIngredient)) {
        mesIngredients.remove_if([ingredient](const auto& pair) {
            return pair.first == nomIngredient;
        });
    }

}




