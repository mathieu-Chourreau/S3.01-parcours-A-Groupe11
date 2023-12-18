#include "Recette.h"
#include "Ingredient.h"
#include <utility>
#include <algorithm>
#include <map>
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

void Recette::setNom(const string& nvNom) {
    nom = nvNom;
}

const string& Recette::getPrix() const {
    return prix;
}

void Recette::setPrix(const string& nvPrix) {
    prix = nvPrix;
}

const string& Recette::getTemps() const {
    return temps;
}

void Recette::setTemps(const string& nvTemps) {
    temps = nvTemps;
}

int Recette::getDifficulte() const {
    return difficulte;
}

void Recette::setDifficulte(int nvDifficulte) {
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

/*void Recette::ajouterIngredient(const Ingredient& ingredient, const string& poids) {
    bool ingredientExiste = !existeIngredient(ingredient.getNom());

    if (ingredientExiste) {
        mesIngredients.push_back(make_pair(ingredient, poids));
    }

}

void retirerIngredient( string &nomIngredient){

    if (existeIngredient(nomIngredient)) {

        mesIngredients.remove_if([ingredient](const auto& pair) {
            return pair.first == ingredient.getNom();
        });
    }

}


bool Recette::existeIngredient(string &nomIngredient) const {
    return std::any_of(mesIngredients.begin(), mesIngredients.end(), 
                       [ingredient](const auto& pair) {
                           return pair.first == nomIngredient;
                       });
}
*/
