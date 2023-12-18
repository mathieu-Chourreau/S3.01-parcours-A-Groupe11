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

class Recette{

private:
    int id;
    float temps;
    string nom;
    string difficulte;
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

    const string &getDifficulte() const;
    void setDifficulte(const string &newDifficulte);

    const string &getCategorie() const;
    void setCategorie(const string &newCategorie);

    ListesIngredients getMesIngredients();

    void ajouterIngredient(const Ingredient &ingredient, const string &poids);
    void retirerIngredient(string &nomIngredient);
    bool existeIngredient(string &nomIngredient) const;
};

#endif