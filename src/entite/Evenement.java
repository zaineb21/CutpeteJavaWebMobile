/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package entite;

import java.util.Date;

/**
 *
 * @author Nidhal
 */
public class Evenement {

    private int id;
    private String nom;
    private String date;
    private double nbparti;
    private double tarif;
    private String lieu;
    private String description;
    private double nbplace;
    private long nbjoursrestant;
    private int nbplacerest;

    public Evenement() {
    }

    public Evenement(int id, String nom, String date, int nbparti, float tarif, String lieu, String description, int nbplace, long nbjoursrestant, int nbplacerest) {
        this.id = id;
        this.nom = nom;
        this.date = date;
        this.nbparti = nbparti;
        this.tarif = tarif;
        this.lieu = lieu;
        this.description = description;
        this.nbplace = nbplace;
        this.nbjoursrestant = nbjoursrestant;
        this.nbplacerest = nbplacerest;
    }

    public Evenement(String nom, String date, int nbparti, float tarif, String lieu, String description, int nbplace, long nbjoursrestant, int nbplacerest) {
        this.nom = nom;
        this.date = date;
        this.nbparti = nbparti;
        this.tarif = tarif;
        this.lieu = lieu;
        this.description = description;
        this.nbplace = nbplace;
        this.nbjoursrestant = nbjoursrestant;
        this.nbplacerest = nbplacerest;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public double getNbparti() {
        return nbparti;
    }

    public void setNbparti(double nbparti) {
        this.nbparti = nbparti;
    }

    public double getTarif() {
        return tarif;
    }

    public void setTarif(double tarif) {
        this.tarif = tarif;
    }

    public String getLieu() {
        return lieu;
    }

    public void setLieu(String lieu) {
        this.lieu = lieu;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public double getNbplace() {
        return nbplace;
    }

    public void setNbplace(double nbplace) {
        this.nbplace = nbplace;
    }

    public long getNbjoursrestant() {
        return nbjoursrestant;
    }

    public void setNbjoursrestant(long nbjoursrestant) {
        this.nbjoursrestant = nbjoursrestant;
    }

    public int getNbplacerest() {
        return nbplacerest;
    }

    public void setNbplacerest(int nbplacerest) {
        this.nbplacerest = nbplacerest;
    }

    @Override
    public String toString() {
        return "Evenement{" + "id=" + id + ", nom=" + nom + ", date=" + date + ", nbparti=" + nbparti + ", tarif=" + tarif + ", lieu=" + lieu + ", description=" + description + ", nbplace=" + nbplace + ", nbjoursrestant=" + nbjoursrestant + ", nbplacerest=" + nbplacerest + '}';
    }

   

    
    
}
