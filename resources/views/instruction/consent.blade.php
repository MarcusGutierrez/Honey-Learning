@extends('layouts.master')

@section('content')

<div class="col-md-10 col-md-offset-2">

    <div class="card" style="width: 56vw;">

        <div>
            @include('layouts.errors')
        </div>
        
        <div class="card-header">
            <h4 class="card-title">Consent Form</h4>
        </div>
        <div class="card-block">
            <h5 class="card-title">Overview</h5>
            <p class="card-text">This task is part of a research study conducted by Dr. Cleotilde Gonzalez 
                at Carnegie Mellon University. The purpose of the research is to explore the various factors 
                that affect decisions in the cyber security domain over repeated choices in individuals and 
                competitive situations with more two or more people. This project is funded by the Army 
                Research Laboratory, ARL-CRA-Cylab-Pennsylvania State University.
            </p>

            <h5 class="card-title">Procedures</h5>
            <p class="card-text">Throughout the experiment, you will be making a series of decisions involving 
                one of three possible situations: 1) classification decisions, 2) choice decisions, and 3) 
                decisions in competitive 2-person and more than two person games.  Regardless of the particular 
                situation you are presented with, your decisions will be separated in a number of trials and 
                you will be provided with feedback that reflects the accuracy of your decisions, according to 
                the instructions provided in this experiment.  The feedback will be shown to you in a number 
                of points which are accumulated throughout the trials, and at the end of the experiment this 
                will be turned into the total amount you earned.  The accumulated number of points will 
                represent the rewards you obtain for making accurate decisions.
            </p>
            
            <h5 class="card-title">Participant Requirements</h5>
            <p class="card-text">Participation in this study is limited to individuals age 18 and older, 
                currently residing in the United States, with at least basic computer proficiency, and the 
                ability to read and understand English.
            </p>
            
            <h5 class="card-title">Risks</h5>
            <p class="card-text">The risks and discomfort associated with participation in this study are 
                no greater than those ordinarily encountered in daily life or during other online activities.
            </p>
            
            <h5 class="card-title">Benefits</h5>
            <p class="card-text">There may be no personal benefit from your participation in the study but the
                knowledge received may be of value to humanity. 
            </p>
            
            <h5 class="card-title">Compensation & Costs</h5>
            <p class="card-text">You will be compensated for completing the game at the rate initially advertised. 
                You will only be eligible for compensation if you have completed the game in full and supplied 
                the appropriate confirmation code. There is no partial payment if you do not complete the study. 
                You will not be penalized if you choose to withdraw from the study without completing it, but you 
                will not be compensated either. There will be no cost to you if you participate in this study.
            </p>
            
            <h5 class="card-title">Confidentiality</h5>
            <p class="card-text">The data captured for the research does not include any personally identifiable 
                information about you. By participating in this research, you understand and agree that Carnegie 
                Mellon may be required to disclose your consent form, data and other personally identifiable 
                information as required by law, regulation, subpoena or court order.  Otherwise, your 
                confidentiality will be maintained in the following manner:
            </p>
            <p class="card-text">Your data and consent form will be kept separate. Your consent form will be stored 
                in a locked location on Carnegie Mellon property and will not be disclosed to third parties. 
                By participating, you understand and agree that the data and information gathered during this 
                study may be used by Carnegie Mellon and published and/or disclosed by Carnegie Mellon to others 
                outside of Carnegie Mellon.
            </p>
            <p class="card-text">In addition, the sponsor of this study, the Army Research Laboratory, 
                ARL-CRA-Cylab-Pennsylvania State University, will have access to your research information. 
            </p>
            
            <h5 class="card-title">Right to Ask Questions & Contact Information</h5>
            <p class="card-text">If you have any questions about this study, you should feel free to ask them by 
                contacting the Principal Investigator now at:
            </p>
            <p class="card-text">
                Professor Cleotilde Gonzalez<br>
                Social and Decision Sciences Department<br>
                Pittsburgh, PA 15213<br>
                (412) 268-6242<br>
                conzalez@andrew.cmu.edu
            </p>
            <p class="card-text">If you have questions later, desire additional information, or wish to withdraw 
                your participation please contact the Principal Investigator by mail, phone or e-mail in accordance 
                with the contact information listed above. 
            </p>
            <p class="card-text">If you have questions pertaining to your rights as a research participant; or to 
                report objections to this study, you should contact the Office of Research integrity and Compliance 
                at Carnegie Mellon University. Email: irb-review@andrew.cmu.edu. Phone: 412-268-1901 or 412-268-5460.
            </p>
            
            <h5 class="card-title">Voluntary Participation</h5>
            <p class="card-text">Your participation in this research is voluntary.  You may discontinue participation 
                at any time during the research activity.
            </p>
            
            <form method="POST" action="/consent">
                
                {{ csrf_field()}}
                
                <fieldset class="form-group row">
                    <legend class="col-form-legend col-sm-10">I am 18 years or older:</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q1"  value="yes">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q1"  value="no">
                                No
                            </label>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-group row">
                    <legend class="col-form-legend col-sm-10">I have read and understand the instructions above:</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q2"  value="yes">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q2"  value="no">
                                No
                            </label>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-group row">
                    <legend class="col-form-legend col-sm-10">I want to participate in this research and continue with the game:</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q3"  value="yes">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q3"  value="no">
                                No
                            </label>
                        </div>
                    </div>
                </fieldset>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="cursor:pointer">Submit</button>
                </div>

            </form>
        </div>
        
    </div>

</div>

@endsection('content')