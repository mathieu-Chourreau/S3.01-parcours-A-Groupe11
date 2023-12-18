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
using namespace std;

typedef pair<int/*a remplir*/, int> PoidIngredient;
typedef list<PoidIngredient> lIngredient;
class Recette
{
private:
    string nom;
    unsigned int prix;  
    string temps;
    unsigned difficulte;
    string categorie;
    string ustencile;
    lIngredient mesIngredients;
public:
    Recette(/* args */);
    ~Recette();
};

Recette::Recette(/* args */)
{
}

Recette::~Recette()
{
}

#endif