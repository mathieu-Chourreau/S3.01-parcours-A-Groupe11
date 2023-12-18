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
#include <list>
#include <utility>
#include "Ingredient.h"
using namespace std;

class Ingredient;

class Recette {
private:
    string temps;
    string nom;
    int difficulte;
    string categorie;
    string prix;

public:
    typedef list<pair<Ingredient, string>> ListesIngredients;
    ListesIngredients mesIngredients;

public:
    Recette();
    Recette(const string& RNom);

    const string& getNom() const;
    void setNom(const string& newNom);

    const string& getPrix() const;
    void setPrix(const string& newPrix);

    const string& getTemps() const;
    void setTemps(const string& newTemps);

    int getDifficulte() const;
    void setDifficulte(int newDifficulte);

    const string& getCategorie() const;
    void setCategorie(const string& newCategorie);

    ListesIngredients getMesIngredients();
};

#endif