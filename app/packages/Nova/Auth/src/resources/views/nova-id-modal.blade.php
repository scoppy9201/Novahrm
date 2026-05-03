<style>
#nid-form .nid-step          { display: none; }
#nid-form[data-step="1"] .nid-step-1 { display: flex; }
#nid-form[data-step="2"] .nid-step-2 { display: flex; }
#nid-form[data-step="3"] .nid-step-3 { display: flex; }

.nid-otp-input {
    width: 44px; height: 52px;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 20px; font-weight: 700;
    color: #0d1729;
    text-align: center;
    font-family: 'Be Vietnam Pro', sans-serif;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    caret-color: #1565C0;
}
.nid-otp-input:focus {
    border-color: #1565C0;
    box-shadow: 0 0 0 3px rgba(21,101,192,.1);
}
.nid-otp-input.nid-otp-filled {
    border-color: #1565C0;
    background: #f0f7ff;
}
.nid-otp-input.nid-otp-error {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239,68,68,.08);
}

.nid-btn-primary {
    width: 100%; padding: 11.5px;
    background: #1565C0; color: #fff;
    border: none; border-radius: 10px;
    font-size: 14px; font-weight: 700;
    cursor: pointer;
    font-family: 'Be Vietnam Pro', sans-serif;
    transition: background .2s, opacity .2s;
    letter-spacing: .1px;
}
.nid-btn-primary:hover:not(:disabled)  { background: #0d47a1; }
.nid-btn-primary:disabled              { background: #cbd5e1; cursor: not-allowed; }

.nid-btn-outline {
    flex: 1; padding: 11px;
    background: #fff; color: #374151;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    font-size: 13.5px; font-weight: 600;
    cursor: pointer;
    font-family: 'Be Vietnam Pro', sans-serif;
    transition: border-color .2s, background .2s;
}
.nid-btn-outline:hover { border-color: #1565C0; color: #1565C0; }
.nid-btn-outline:disabled { opacity: .5; cursor: not-allowed; }

.nid-resend-active   { color: #1565C0; cursor: pointer; font-weight: 600; }
.nid-resend-active:hover { text-decoration: underline; }
.nid-resend-disabled { color: #94a3b8; cursor: default; font-weight: 500; }
</style>

<div id="novaIdOverlay" style="display:none; position:fixed; inset:0; z-index:9999; background:#e8f0fb; font-family:'Be Vietnam Pro',sans-serif; overflow:hidden;">

    {{-- Background shapes --}}
    <div style="position:absolute;inset:0;pointer-events:none;overflow:hidden;">
        <div style="position:absolute;top:-10%;right:-5%;width:55%;height:80%;background:linear-gradient(160deg,#dce9f8 0%,#c9dff5 100%);border-radius:0 0 0 80px;transform:rotate(-8deg);opacity:.6;"></div>
        <div style="position:absolute;bottom:-15%;left:-5%;width:45%;height:60%;background:linear-gradient(340deg,#d4e6f7 0%,#e0edf9 100%);border-radius:80px 80px 0 0;opacity:.4;"></div>
    </div>

    {{-- Header --}}
    <div style="position:absolute;top:0;left:0;right:0;padding:1.25rem 2.5rem;display:flex;align-items:center;justify-content:space-between;z-index:2;">
        <div style="display:flex;align-items:center;gap:8px;">
            <div style="width:28px;height:28px;background:linear-gradient(135deg,#1565C0,#42A5F5);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <svg width="14" height="14" viewBox="0 0 16 16" fill="white"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
            </div>
            <span style="font-size:14px;font-weight:800;color:#1565C0;">Nova<span style="color:#0d1729;">ID</span></span>
        </div>
        <button onclick="NID.close()" style="background:rgba(255,255,255,.7);border:1px solid rgba(0,0,0,.08);border-radius:8px;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .15s;" onmouseover="this.style.background='#fff'" onmouseout="this.style.background='rgba(255,255,255,.7)'">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#4a6080" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    {{-- Card --}}
    <div style="position:relative;z-index:1;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:5rem 1.5rem;">
        <div style="background:#fff;border-radius:20px;border:1px solid rgba(0,0,0,.06);width:100%;max-width:860px;display:grid;grid-template-columns:1fr 1fr;box-shadow:0 8px 48px rgba(21,101,192,.1);overflow:hidden;">

            {{-- LEFT: Branding (tĩnh, không đổi) --}}
            <div style="padding:3rem;display:flex;flex-direction:column;justify-content:center;border-right:1px solid #f0f4f9;">
                <div style="display:flex;align-items:center;gap:9px;margin-bottom:2rem;">
                    <div style="width:34px;height:34px;background:linear-gradient(135deg,#1565C0,#42A5F5);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <svg width="17" height="17" viewBox="0 0 16 16" fill="white">
                            <path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/>
                        </svg>
                    </div>
                    <span style="font-size:16px;font-weight:800;color:#1565C0;">
                        {{ config('app.name', 'Nova') }}
                        <span style="color:#0d1729;">ID</span>
                    </span>
                </div>
                <h2 style="font-size:30px;font-weight:900;color:#0d1729;letter-spacing:-.8px;line-height:1.2;margin:0 0 10px;">
                    @lang('nova-auth::app.auth.login_title')
                </h2>
                <p id="nid-left-sub" style="font-size:14px;color:#64748b;margin:0;line-height:1.6;">
                    @lang('nova-auth::app.auth.login_subtitle', [
                        'platform' => __('nova-auth::app.auth.platform')
                    ])
                    <a href="#" style="color:#1565C0;font-weight:700;text-decoration:none;">
                        @lang('nova-auth::app.auth.platform')
                    </a>
                </p>
            </div>

            {{-- RIGHT: Steps --}}
            <div id="nid-form" data-step="1" style="padding:3rem;display:flex;flex-direction:column;justify-content:center;">
                {{-- ══ STEP 1: Email ══ --}}
                <div class="nid-step nid-step-1" style="flex-direction:column;">
                    <div style="margin-bottom:1rem;">
                        <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:7px;">
                            @lang('nova-auth::app.auth.email')
                        </label>
                        <div style="position:relative;">
                            <input
                                id="nid-email-input"
                                type="email"
                                placeholder="@lang('nova-auth::app.auth.email_placeholder')"
                                style="width:100%;background:#fff;border:1.5px solid #e2e8f0;border-radius:10px;padding:11px 42px 11px 14px;font-size:14px;color:#0d1729;font-family:'Be Vietnam Pro',sans-serif;outline:none;box-sizing:border-box;transition:border-color .2s,box-shadow .2s;"
                                onfocus="this.style.borderColor='#1565C0';this.style.boxShadow='0 0 0 3px rgba(21,101,192,.1)'"
                                onblur="this.style.borderColor=document.getElementById('nid-email-error').style.display!='none'?'#ef4444':'#e2e8f0';this.style.boxShadow='none'"
                                oninput="NID.onEmailInput(this)"
                                onkeydown="if(event.key==='Enter')NID.submitEmail()"
                            >
                            <div id="nid-email-err-icon" style="display:none;position:absolute;right:13px;top:50%;transform:translateY(-50%);pointer-events:none;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                            </div>
                        </div>
                        <p id="nid-email-error" style="display:none;font-size:12px;color:#ef4444;margin:6px 0 0 2px;">
                            @lang('nova-auth::app.auth.email_invalid')
                        </p>
                    </div>
                    <p style="font-size:12.5px;color:#94a3b8;line-height:1.7;margin:0 0 1.6rem;">
                        @lang('nova-auth::app.auth.incognito_notice')
                        <strong style="color:#64748b;font-weight:600;">
                            @lang('nova-auth::app.auth.incognito_highlight')
                        </strong>
                        @lang('nova-auth::app.auth.incognito_suffix')
                    </p>
                    <button id="nid-email-btn" onclick="NID.submitEmail()" class="nid-btn-primary" disabled>
                        @lang('nova-auth::app.auth.continue')
                    </button>
                </div>

                {{-- ══ STEP 2: Magic Link sent ══ --}}
                <div class="nid-step nid-step-2" style="flex-direction:column;align-items:center;text-align:center;">
                    <div style="width:72px;height:72px;background:linear-gradient(135deg,#dbeafe,#bfdbfe);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1.4rem;">
                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#1565C0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <p style="font-size:14px;color:#374151;line-height:1.7;margin:0 0 1.6rem;">
                        <strong style="color:#0d1729;">Nova ID</strong>
                        @lang('nova-auth::app.auth.magic_link_sent')
                        <br>

                        <strong id="nid-ml-email" style="color:#1565C0;"></strong>.
                        <br>

                        <span style="color:#64748b;font-size:13px;">
                            @lang('nova-auth::app.auth.magic_link_check')
                        </span>
                    </p>
                    <div style="display:flex;gap:10px;width:100%;">
                        <button onclick="NID.switchToOtp()" class="nid-btn-outline">
                            @lang('nova-auth::app.auth.try_other_method')
                        </button>

                        <button id="nid-ml-resend" onclick="NID.resendMagicLink()" class="nid-btn-outline" disabled>
                            <span id="nid-ml-resend-text">
                                @lang('nova-auth::app.auth.resend')
                                (<span id="nid-ml-countdown">60</span>s)
                            </span>
                        </button>
                    </div>
                </div>
                {{-- ══ STEP 3: OTP ══ --}}
                <div class="nid-step nid-step-3" style="flex-direction:column;">
                    <p style="font-size:13.5px;color:#64748b;margin:0 0 1.4rem;text-align:center;">
                        @lang('nova-auth::app.auth.otp_title')
                    </p>
                    {{-- OTP --}}
                    <div id="nid-otp-wrap" style="display:flex;gap:8px;justify-content:center;margin-bottom:.6rem;">
                        <input class="nid-otp-input" type="text" inputmode="numeric" maxlength="1" data-idx="0">
                        <input class="nid-otp-input" type="text" inputmode="numeric" maxlength="1" data-idx="1">
                        <input class="nid-otp-input" type="text" inputmode="numeric" maxlength="1" data-idx="2">
                        <input class="nid-otp-input" type="text" inputmode="numeric" maxlength="1" data-idx="3">
                        <input class="nid-otp-input" type="text" inputmode="numeric" maxlength="1" data-idx="4">
                        <input class="nid-otp-input" type="text" inputmode="numeric" maxlength="1" data-idx="5">
                    </div>
                    <p id="nid-otp-error" style="display:none;font-size:12px;color:#ef4444;text-align:center;margin:0 0 .8rem;">
                        @lang('nova-auth::app.auth.otp_invalid')
                    </p>
                    <p style="font-size:12.5px;color:#94a3b8;text-align:center;margin:0 0 1.4rem;">
                        @lang('nova-auth::app.auth.otp_not_received')&nbsp;

                        <span id="nid-otp-resend" class="nid-resend-disabled" onclick="NID.resendOtp()">
                            @lang('nova-auth::app.auth.resend_otp')
                            (<span id="nid-otp-countdown">60</span>s)
                        </span>
                    </p>
                    <button id="nid-otp-btn" onclick="NID.submitOtp()" class="nid-btn-primary" disabled>
                        @lang('nova-auth::app.auth.confirm')
                    </button>
                    <button onclick="NID.goStep(1)"
                        style="background:none;border:none;color:#94a3b8;font-size:12.5px;cursor:pointer;font-family:'Be Vietnam Pro',sans-serif;margin-top:.9rem;"
                        onmouseover="this.style.color='#1565C0'"
                        onmouseout="this.style.color='#94a3b8'">

                        <i class="fa-solid fa-arrow-left"></i>
                        @lang('nova-auth::app.auth.back')
                    </button>
                </div>

                {{-- Footer --}}
                <div style="margin-top:1.5rem;text-align:center;display:flex;align-items:center;justify-content:center;gap:4px;flex-wrap:wrap;">
                    <span style="font-size:11.5px;color:#94a3b8;">
                        @lang('nova-auth::app.footer.protected_by')
                    </span>
                    <span style="font-size:11.5px;font-weight:800;color:#1565C0;">Nova</span>
                    <span style="font-size:11.5px;font-weight:800;color:#0d1729;">ID</span>
                    <span style="color:#d1d5db;font-size:11.5px;">·</span>
                    <a href="#"
                        style="font-size:11.5px;color:#94a3b8;text-decoration:none;"
                        onmouseover="this.style.color='#1565C0'"
                        onmouseout="this.style.color='#94a3b8'">
                        @lang('nova-auth::app.footer.terms')
                    </a>
                    <span style="color:#d1d5db;font-size:11.5px;">·</span>
                    <a href="#"
                        style="font-size:11.5px;color:#94a3b8;text-decoration:none;"
                        onmouseover="this.style.color='#1565C0'"
                        onmouseout="this.style.color='#94a3b8'">
                        @lang('nova-auth::app.footer.privacy')
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div style="position:absolute;bottom:0;left:0;right:0;padding:1rem 2.5rem;display:flex;align-items:center;justify-content:space-between;z-index:2;">
        <select style="background:rgba(255,255,255,.8);border:1px solid rgba(0,0,0,.1);border-radius:8px;padding:5px 10px;font-size:12px;color:#4a6080;cursor:pointer;font-family:'Be Vietnam Pro',sans-serif;">
            <option value="vi">
                @lang('nova-auth::app.language.vi')
            </option>

            <option value="en">
                @lang('nova-auth::app.language.en')
            </option>
        </select>

        <div style="display:flex;align-items:center;gap:6px;">
            <div style="width:18px;height:18px;background:linear-gradient(135deg,#1565C0,#42A5F5);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <svg width="9" height="9" viewBox="0 0 16 16" fill="white">
                    <path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/>
                </svg>
            </div>
            <span style="font-size:12px;color:#94a3b8;">
                @lang('nova-auth::app.brand.powered_by')
            </span>
        </div>

        <div style="display:flex;gap:1.4rem;">
            <a href="#"
                style="font-size:12px;color:#94a3b8;text-decoration:none;"
                onmouseover="this.style.color='#1565C0'"
                onmouseout="this.style.color='#94a3b8'">
                @lang('nova-auth::app.footer.help')
            </a>
            <a href="#"
                style="font-size:12px;color:#94a3b8;text-decoration:none;"
                onmouseover="this.style.color='#1565C0'"
                onmouseout="this.style.color='#94a3b8'">
                @lang('nova-auth::app.footer.privacy')
            </a>
            <a href="#"
                style="font-size:12px;color:#94a3b8;text-decoration:none;"
                onmouseover="this.style.color='#1565C0'"
                onmouseout="this.style.color='#94a3b8'">

                @lang('nova-auth::app.footer.terms')
            </a>
        </div>
    </div>
</div>