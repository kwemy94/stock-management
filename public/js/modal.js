window.onload = function () {
    if (!window.jQuery)
        console.error("Step modal plugin needs jQuery in order to work...");
}
var stepModalObjectHolder = function (element, options) {
    // search for modals
    if ($(element).length < 1 || !$(element).hasClass("modal-steps"))
        return console.error("No modal found");
    var bootstrapModal = new bootstrap.Modal(element);
    var options = (typeof options !== 'undefined' ? options : {})
    this.options = {
        stepListClickable: (typeof options.stepListClickable !== 'undefined' ? options.stepListClickable : true),
        prevBtnCancelTextActive: (typeof options.prevBtnCancelTextActive !== 'undefined' ? options.prevBtnCancelTextActive : true),
        prevBtnCancelText: (typeof options.prevBtnCancelText !== 'undefined' ? options.prevBtnCancelText : 'Cancel'),
        nextBtnFinishTextActive: (typeof options.nextBtnFinishTextActive !== 'undefined' ? options.nextBtnFinishTextActive : true),
        nextBtnFinishText: (typeof options.nextBtnFinishText !== 'undefined' ? options.nextBtnFinishText : 'Finish'),
        onFinish: function(){
			  (typeof options.onFinish !== 'undefined' ? options.onFinish : function () {});
			  bootstrapModal.hide()
		  },
        onCancel: function(){
			 (typeof options.onFinish !== 'undefined' ? options.onCancel : function () {});
			  bootstrapModal.hide()
		  },
    };
    this.element = $(element);
    this.uid = (Math.random() + 1).toString(36).substring(10);
    this.currentstep = 0;
    var steps = new Array;
    element.find('.modal-steps-list .modal-step').each(function () {
        var elementid = $(this).attr('id');
        // check if step has id otherwise create 
        if (typeof elementid == "undefined") {
            elementid = 'modalstep-' + (Math.random() + 1).toString(36).substring(4);
            $(this).attr('id', elementid)
        }
        steps.push(elementid);
    });
    // Link the modal body
    element.find('.modal-step-body').each(function (i) {
        var linkedto = $(this).attr('data-mstep');
        // check if body has id otherwise create 
        if (typeof elementid == "undefined") {
            linkedto = '#' + steps[i];
            $(this).attr('data-mstep', linkedto)
        }
    });
    this.steps = steps;
    this.btn = {
        next: element.find("[data-mstep-btn='next']"),
        prev: element.find("[data-mstep-btn='previous']"),
        texts: {
            next: element.find("[data-mstep-btn='next']").html(),
            prev: element.find("[data-mstep-btn='previous']").html()
        }
    }
    // control the modal
    this.control = function () {
        var object = this;
        var modalBodies = element.find('.modal-step-body');
        var max = (object.steps.length - 1);
        return {
            nextStep: function () {
                object.currentstep = object.currentstep + 1;
                if (object.currentstep > max)
                    return this.finish();
                this.refresh();
            },
            prevStep: function () {
                object.currentstep = object.currentstep - 1;
                if (object.currentstep < 0)
                    return this.cancel();
                this.refresh();
            },
            setStep: function (step) {
                if (step > max)
                    return console.error("max steps");
                object.currentstep = step;
                this.refresh();
            },
            refresh: function () {
                if (object.currentstep == 0 && object.options.prevBtnCancelTextActive === true) {
                    object.btn.prev.html(object.options.prevBtnCancelText);
                } else {
                    object.btn.prev.html(object.btn.texts.prev);
                }
                if (object.currentstep == max && object.options.nextBtnFinishTextActive === true) {
                    object.btn.next.html(object.options.nextBtnFinishText);
                } else {
                    object.btn.next.html(object.btn.texts.next);
                }
                object.steps.forEach((id, index) => {
                    modalBodies.removeClass('step-active');
                    $("#" + id).removeClass('step-active');
                    if (index == object.currentstep) {
                        setTimeout(function () {
                            $("#" + id).addClass('step-active');
                            $(".modal-step-body[data-mstep='#" + id + "']").addClass('step-active');
                        }, 10);
                    }
                });
            },
            finish: function () {
                object.currentstep = 0;
                $(element).trigger('finish');
				
            },
            cancel: function () {
                object.currentstep = 0;
                $(element).trigger('cancel');
            }
        }
    }
    this.control().refresh();
    var modalobject = this;
    if (typeof this.btn.next !== 'undefined') {
        this.btn.next.off();
        this.btn.next.on('click', function () {
            modalobject.control().nextStep();
        });
    }
    if (typeof this.btn.prev !== 'undefined') {
        this.btn.prev.off();
        this.btn.prev.on('click', function () {
            modalobject.control().prevStep();
        });
    }
    if (this.options.stepListClickable) {
        element.find('.modal-steps-list .modal-step').css('cursor', 'pointer');
        element.find('.modal-steps-list .modal-step').on('click', function () {
            modalobject.control().setStep($(this).index());
        });
    }
};
(function ($) {
    $.fn.stepModal = function (options) {
        var modalObject = new stepModalObjectHolder($(this), options);
        $(modalObject.element).bind("finish", function () {
            modalObject.options.onFinish();
        });
        $(modalObject.element).bind("cancel", function () {
            modalObject.options.onCancel();
        });
        return modalObject;
    };
})(jQuery);
$(document).ready(function () {
    var theModal = $(".modal-steps").stepModal();
})