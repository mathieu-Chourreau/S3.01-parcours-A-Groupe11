/**
 * @file Recette.h
 * @author CHOURREAU,FERME,PIEL,ZAZA
 * @brief
 * @version 0.1
 * @date 2023-11-16
 *
 * @copyright Copyright (c) 2023
 *
 */

#ifndef RECETTE_H
#define RECETTE_H

#include <iostream>
#include <map>
#include <list>
#include "Ingredient.h"
using namespace std;

class Ingredient;
enum Difficulte {facile = 1, moyen = 2, difficile = 3};
class Recette{

private:
    int id;
    float temps;
    string nom;
    Difficulte difficulte;
    string categorie;
    float prix;
    typedef list<pair<Ingredient, float>> ListesIngredients;
    ListesIngredients mesIngredients;

public:
    Recette();
    Recette(const string &RNom);

    const int &getId() const;
    void setId(const int &newId);

    const string &getNom() const;
    void setNom(const string &newNom);

    const float &getPrix() const;
    void setPrix(const float &newPrix);

    const float &getTemps() const;
    void setTemps(const float &newTemps);

    const Difficulte &getDifficulte() const;
    void setDifficulte(const Difficulte &newDifficulte);

    const string &getCategorie() const;
    void setCategorie(const string &newCategorie);

    ListesIngredients getMesIngredients();

    bool comparerIngredients(Ingredient ingredient, Ingredient ingRecherche);

    void ajouterIngredient(Ingredient ingredient, string poids);
    void retirerIngredient(Ingredient ingredient);
    bool existeIngredient(Ingredient ingredient) ;
};

#endif