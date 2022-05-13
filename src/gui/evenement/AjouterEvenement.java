/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui.evenement;

import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.Display;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import static com.codename1.ui.events.ActionEvent.Type.Command;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.spinner.Picker;
import entite.Evenement;
import java.util.Date;
import service.ServiceEvenement;

/**
 *
 * @author Nidhal
 */
public class AjouterEvenement extends Form {

    public AjouterEvenement() {
        setTitle("Ajouter un nouveau Evenement");
        setLayout(BoxLayout.y());
        TextField Ffnom = new TextField("", "Nom");

        Picker date = new Picker();
        date.setType(Display.PICKER_TYPE_DATE);
        TextField Ffnbparti = new TextField("", "NBparti");
        TextField Fftarif = new TextField("", "Tarif");
        TextField FfLieu = new TextField("", "Lieu");
        TextField Ffdescription = new TextField("", "Description");
        
        
        
        TextField Ffnbplace = new TextField("", "NBplace");
        Button btnValider = new Button("Ajouter");
        btnValider.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent evt) {
                if ((Ffnom.getText().length() == 0) || (Ffdescription.getText().length() == 0) || (FfLieu.getText().length() == 0) || (Ffnbparti.getText().length() == 0) || (Fftarif.getText().length() == 0) || (Ffnbplace.getText().length() == 0) ) {
                    Dialog.show("Erreur", "Veuillez remplir le formulaire", new Command("Ok"));
                } else {
                    try {
                        
                        Evenement F = new Evenement(
                                Ffnom.getText(),
                                date.getDate().toString(),
                                Integer.parseInt(Ffnbparti.getText()),
                                Float.parseFloat(Fftarif.getText()),
                                FfLieu.getText(),
                                Ffdescription.getText(),
                                Integer.parseInt(Ffnbplace.getText()),
                                0,
                                0);
                                
                                
                                 
                               
                        
                        System.out.println(F);
                        if (new ServiceEvenement().addEvenement(F)) {
                            
                            Ffnom.setText(""); 
                            date.setDate(null);
                            Ffnbparti.setText("");
                            Fftarif.setText("");
                            FfLieu.setText("");
                            Ffdescription.setText("");
                            Ffnbplace.setText("");
                            
                            Dialog.show("Success", "Connection accepted", new Command("OK"));
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
        addAll(Ffnom,date, Ffnbparti, Fftarif, FfLieu, Ffdescription, Ffnbplace, btnValider);

    }
}
