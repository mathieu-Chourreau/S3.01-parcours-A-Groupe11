#include "Recette.h"
#include "Ingredient.h"
#include <utility>
#include <algorithm>
#include <map>
#include <iostream>

class Ingredient;

Recette::Recette()
{
    difficulte = 1;
}

Recette::Recette(const string &RNom)
{
    nom = RNom;
    difficulte = 1;
}

const string &Recette::getNom() const
{
    return nom;
}

void Recette::setNom(const string &nvNom)
{
    nom = nvNom;
}

const string &Recette::getPrix() const
{
    return prix;
}

void Recette::setPrix(const string &nvPrix)
{
    prix = nvPrix;
}

const string &Recette::getTemps() const
{
    return temps;
}

void Recette::setTemps(const string &nvTemps)
{
    temps = nvTemps;
}

int Recette::getDifficulte() const
{
    return difficulte;
}

void Recette::setDifficulte(int nvDifficulte)
{
    difficulte = nvDifficulte;
}

const string &Recette::getCategorie() const
{
    return categorie;
}

void Recette::setCategorie(const string &nvCategorie)
{
    categorie = nvCategorie;
}

Recette::ListesIngredients Recette::getMesIngredients()
{
    return mesIngredients;
}

bool Recette::comparerIngredients(Ingredient ingredient, Ingredient ingRecherche)
{
    return (ingredient.getNom() == ingRecherche.getNom());
}

bool Recette::existeIngredient(Ingredient ingRecherche)
{
    auto existe = std::find_if(mesIngredients.begin(), mesIngredients.end(),
        [this, ingRecherche](const Ingredient& ingredient) {
            return comparerIngredients(ingredient, ingRecherche);
        });

    return (existe != mesIngredients.end());
}

void Recette::ajouterIngredient(Ingredient ingredient, string poids) {
    if (!existeIngredient(ingredient)) {
        mesIngredients.push_back(make_pair(ingredient, poids));
    }
}

void Recette::retirerIngredient(Ingredient ingredient){
     // Utilisation d'un itérateur pour parcourir la liste et supprimer l'élément
    for (auto iterator = mesIngredients.begin(); iterator != mesIngredients.end();) {
        // Vérification de la valeur de la première composante de la paire
        if (iterator->first.getNom() == ingredient.getNom()) {
            // Suppression de l'élément correspondant
            iterator = mesIngredients.erase(iterator);
        } else {
            // Passer à l'élément suivant dans la liste
            ++iterator;
        }
    }
}


