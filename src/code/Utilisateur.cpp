#include "Utilisateur.h"

Utilisateur::Utilisateur(int i, string n, string p, int b, int t)
{
    set_identifiant(i);
    set_nom(n);
    set_prenom(p);
    set_budget(b);
    set_tempsMax(t);
}

void Utilisateur::set_identifiant(int id)
{  
    this->identifiant = id; 
}

int Utilisateur::get_identifiant()
{
    return this->identifiant;
}

void Utilisateur::set_nom(string nom)
{
    this->nom = nom;
}

string Utilisateur::get_nom()
{
    return this->nom;
}

void Utilisateur::set_prenom(string prenom)
{
    this->prenom = prenom;
}

string Utilisateur::get_prenom()
{
    return this->prenom;
}

void Utilisateur::set_budget(int budget)
{
    this->budget = budget;
}

int Utilisateur::get_budget()
{
    return this->budget;
}

void Utilisateur::set_tempsMax(int temps)
{
    this->tempsMax = temps;
}

int Utilisateur::get_tempsMax()
{
    return this->tempsMax;
}

bool Utilisateur::ajouter_preference(Ingredient& i, int pref)
{
    Inserer insertion = this->preference.insert(i);
    return insertion.second;
}

bool Utilisateur::retirer_preference(Ingredient& i)
{   
    Preference::iterator existe;
    existe = this->preference.find(i);
    if(existe != this->preference.end()){
        this->preference.erase(existe);
        return true;
    }
    else
    {
        return false;
    }
}

bool Utilisateur::existe_preference(Ingredient& i)
{
    Preference::iterator existe;
    existe = this->preference.find(i);

    if (existe != this->preference.end())
    {
        return true;
    }
    else
    {
        return false;
    }
}
