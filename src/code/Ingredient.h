/**
 * @file Ingredient.h
 * @author Chourreau Mathieu, Fermé Léo, Piel Nathan, Zaza Souleymen
 * @brief 
 * @version 0
 * @date 2023-11-16
 * 
 * @copyright Copyright (c) 2023
 * 
 */

#include <iostream>
using namespace std;

#ifndef INGREDIENT_H
#define INGREDIENT_H
#include "Recette.h"

class Recette;

class Ingredient {
private:
    string nom;
    float prix;
    Recette* maRecette;
    string categorie;

public:
    Ingredient();
    Ingredient(const string& INom, const float& IPrix, const string& ICategorie);
    Ingredient(const Ingredient& Ing);

    const string& getNom() const;
    void setNom(const string& newNom);

    const float& getPrix() const;
    void setPrix(const float& newPrix);

    Recette* getMaRecette() const;
    void setMaRecette(Recette* newRecette);

    const string& getCategorie() const;
    void setCategorie(const string& newCategorie);

    void lierIngredient(Recette* recette);
    void delierIngredient();
};


#endif