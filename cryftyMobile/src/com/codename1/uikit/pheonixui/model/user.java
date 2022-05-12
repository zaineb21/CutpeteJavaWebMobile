/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.pheonixui.model;

/**
 *
 * @author Boughnimi
 */
public class user {
    private int id;
    private String nom;
    private String prenom;
    private String email;
    private String password;
    private String numerotelephone;
    private String photo;
   
    public user(String nom, String prenom, String email, String password, String numerotelephone, String photo) {
        
        this.nom = nom;
        this.prenom = prenom;
        this.email = email;
        this.password = password;
        this.numerotelephone= numerotelephone;
        this.photo = photo;
    }
 
     public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }
       public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }
    
     public String getPassword() {
        return password;
    }

    public void setPassword(String motdepasse) {
        this.password = password;
    }
    
    public String getPhoto() {
        return photo;
    }

    public void setPhoto(String photo) {
        this.photo = photo;
    }
       public String getNumeroTelephone() {
        return numerotelephone;
    }

    public void setNumeroTelephone(String numerotelephone ) {
        this.numerotelephone = numerotelephone;
    }


  
}
