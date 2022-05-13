/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui.evenement;

import com.codename1.l10n.ParseException;
import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.Display;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.spinner.Picker;
import entite.Evenement;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import service.ServiceEvenement;

/**
 *
 * @author Nidhal
 */
public class DetailsEvenement extends Form {

    Evenement event;

    public DetailsEvenement(int evenement_id) {
        setTitle("Détails Evenement");
        ArrayList<Evenement> events = ListeEvenement.events;
        event = new Evenement();
        for (Evenement e : events) {
            if (e.getId() == evenement_id) {
                event = e;
                break;
            }
        }
        setLayout(BoxLayout.y());
        TextField Ffnom = new TextField(event.getNom(), "Nom");
        Picker date = new Picker();
        date.setType(Display.PICKER_TYPE_DATE);
        System.out.print(event.getDate());
        TextField Ffdescription = new TextField(event.getDescription(), "Description");
        TextField FfLieu = new TextField(event.getLieu(), "Lieu");
        TextField Ffnbparti = new TextField(String.valueOf(event.getNbparti()), "nbparti");
        TextField Ffnbplace = new TextField(String.valueOf(event.getNbplace()), "nbplace");
        TextField Fftarif = new TextField(String.valueOf(event.getTarif()), "tarif");
        Button btnModifier = new Button("Modifier");
        Button btnSupprimer = new Button("Supprimer");
        btnModifier.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                if ((Ffnom.getText().length() == 0) || (Ffdescription.getText().length() == 0) || (FfLieu.getText().length() == 0) || (Ffnbplace.getText().length() == 0) || (Fftarif.getText().length() == 0)) {
                    Dialog.show("Erreur", "Veuillez remplir le formulaire", new Command("Ok"));
                } else {
                    try {
                        
                        
                        
                        
                        Date today = new Date();
                        long oneDay = 60*1000*60*24;
                        event.setNom(Ffnom.getText());
                        event.setDate(date.getDate().toString());
                        event.setNbparti(Integer.parseInt(Ffnbparti.getText()));
                        event.setTarif(Float.parseFloat(Fftarif.getText()));
                        event.setLieu(FfLieu.getText());
                        event.setDescription(Ffdescription.getText());
                        event.setNbplace(Integer.parseInt(Ffnbplace.getText()));
                        event.setNbplacerest(Integer.parseInt(Ffnbplace.getText())-Integer.parseInt(Ffnbparti.getText()));
                        event.setNbjoursrestant((date.getDate().getTime()-today.getTime())/oneDay);
                        
                        System.out.println(event);
                        if (new ServiceEvenement().updateEvenement(event)) {
                            
                            Dialog.show("Success", "Evenement Modifier", new Command("OK"));
                            new ListeEvenement().show();
                        } else {
                            Dialog.show("ERRor", "Server error", new Command("OK"));
                        }
                        
                    } catch (NumberFormatException e) {
                        Dialog.show("ERROR", " id must be a number", new Command("OK"));
                    }
                }
            }
        });
        btnSupprimer.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                if (event == null) {
                    Dialog.show("Erreur", "Evenement Introuvable", new Command("Ok"));
                } else {
                    try {
                        
                        if (new ServiceEvenement().deleteEvenements(event.getId())) {
                            Dialog.show("Success", "Evenement Supprimer", new Command("OK"));
                            new ListeEvenement().show();
                        } else {
                            Dialog.show("ERRor", "Server error", new Command("OK"));
                        }
                        
                    } catch (NumberFormatException e) {
                        Dialog.show("ERROR", " error", new Command("OK"));
                    }
                }
            }
        });
        addAll(Ffnom, date, Ffnbparti, Fftarif, FfLieu, Ffdescription, Ffnbplace, btnModifier, btnSupprimer);

    }

}
