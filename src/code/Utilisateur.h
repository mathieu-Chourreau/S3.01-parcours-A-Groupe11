/**
 * @file Utilisateur.h
 * @author CHOURREAU,FERME,PIEL,ZAZA 
 * @brief 
 * @version 0.1
 * @date 2023-12-18
 * 
 * @copyright Copyright (c) 2023
 * 
 */

#ifndef UTILISATEUR_H
#define UTILISATEUR_H
#include <iostream>
#include <map>
#include <list>
using namespace std;
#include "Ingredient.h"


class Utilisateur
{
private:
    typedef map<Ingredient, int> Preference;
    typedef pair<Preference::iterator, bool> Inserer;
    /*DONNEE*/
    int identifiant;
    string nom;
    string prenom;
    int budget;
    int tempsMax;
    Preference preference;
public:
    Utilisateur(int,string,string,int,int);

    void set_identifiant(int);
    int get_identifiant();

    void set_nom(string);
    string get_nom();

    void set_prenom(string);
    string get_prenom();

    void set_budget(int);
    int get_budget();

    void set_tempsMax(int);
    int get_tempsMax();

    bool ajouter_preference(Ingredient&, int);

    bool retirer_preference(Ingredient&);

    bool existe_preference(Ingredient&);
};



#endif