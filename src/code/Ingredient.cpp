#include "Ingredient.h"
#include "Recette.h" 

Ingredient::Ingredient() {
    maRecette = nullptr;
}

Ingredient::Ingredient(const string& INom, const string& IPrix, const string& ICategorie) {
    nom = INom;
    prix = IPrix;
    maRecette = nullptr;
    categorie = ICategorie;
}

Ingredient::Ingredient(const Ingredient& Ing) {
    nom = Ing.nom;
    prix = Ing.prix;
    maRecette = Ing.maRecette;
    categorie = Ing.categorie;
}

const string& Ingredient::getNom() const {
    return nom;
}

void Ingredient::setNom(const string& newNom) {
    nom = newNom;
}

const string& Ingredient::getPrix() const {
    return prix;
}

void Ingredient::setPrix(const string& newPrix) {
    prix = newPrix;
}

Recette* Ingredient::getMaRecette() const {
    return maRecette;
}

void Ingredient::setMaRecette(Recette* newRecette) {
    maRecette = newRecette;
}

const string& Ingredient::getCategorie() const {
    return categorie;
}

void Ingredient::setCategorie(const string& newCategorie) {
    categorie = newCategorie;
}

void Ingredient::lierIngredient(Recette* recette) {
    maRecette = recette;
}

void Ingredient::delierIngredient() {
    maRecette = nullptr;
}
