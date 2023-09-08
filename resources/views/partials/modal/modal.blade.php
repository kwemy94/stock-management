<!-- This script got from frontendfreecode.com -->
{{-- <div class="container h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-6">
            <div class="bg-dark p-5 text-center rounded shadow-lg">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-test">
                    Launch demo modal
                </button>
            </div>
        </div>
    </div>
</div> --}}
<div id="supcription_app" class="modal modal-steps fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-steps-list">
                    <div id="step-1" class="modal-step step-active">
                        <h2>Step 1</h2>
                        <p>Modal</p>
                    </div>
                    <div id="step-3" class="modal-step">
                        <h2>Step 2</h2>
                        <p>How to use</p>
                    </div>
                    <div id="step-2" class="modal-step">
                        <h2>Step 3</h2>
                        <p>Enjoy</p>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="modal-step-body step-active" data-mstep='#step-1'>
                    <p>A really simple jQuery plugin to make a bootstrap modal with steps.</p>
                    <b>jQuery code</b>
                    <div class="bg-light p-3 mb-3">
                        <code class="d-block text-muted">// Use the bootstrap modal as element</code>
                        <code class="d-block">
                            $(element).stepModal();
                        </code>
                    </div>
                    <b>Options & events</b>
                    <div class="bg-light p-3 mb-3">
                        <code class="d-block">
                            $(element).stepModal({
                        </code>
                        <code class="me-3 d-block">
                            &nbsp;&nbsp;&nbsp;stepListClickable: true,
                        </code>
                        <code class="me-3 d-block">
                            &nbsp;&nbsp;&nbsp;prevBtnCancelTextActive: true,
                        </code>
                        <code class="me-3 d-block">
                            &nbsp;&nbsp;&nbsp;prevBtnCancelText: 'Cancel',
                        </code>
                        <code class="me-3 d-block">
                            &nbsp;&nbsp;&nbsp;nextBtnFinishTextActive: true,
                        </code>
                        <code class="me-3 d-block">
                            &nbsp;&nbsp;&nbsp;nextBtnFinishText: 'Finish',
                        </code>
                        <code class="me-3 d-block">
                            &nbsp;&nbsp;&nbsp;onFinish: function(){},
                        </code>
                        <code class="me-3 d-block">
                            &nbsp;&nbsp;&nbsp;onCancel: function(){},
                        </code>
                        <code class="d-block">
                            });
                        </code>
                    </div>
                </div>
                <div class="modal-step-body" data-mstep='#step-2'>
                    <p>This plugin doesn't generate HTML. You have to make the HTML yourself. Check the codepen source
                        to view the HTML code. Don't forget to include the step buttons!</p>
                </div>
                <div class="modal-step-body" data-mstep='#step-3'>
                    <p>And here you are, a working step modal plugin. Free to use.</p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="m-auto">
                    <button type="button" class="btn btn-outline-primary" data-mstep-btn="previous">Previous
                        step</button>
                    <button type="button" class="btn btn-primary" data-mstep-btn="next">Next step</button>
                </div>
            </div>
        </div>
    </div>
</div>

